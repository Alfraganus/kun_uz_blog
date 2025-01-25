<?php

namespace app\controllers;

use app\models\CompanyProfile;
use app\models\User;
use Carbon\Carbon;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AuthController extends Controller
{

    public $layout='auth';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionRegister()
    {
        $userModel = new User();
        $userProfile = new CompanyProfile();
          if ($userModel->load(Yii::$app->request->post()) && $userProfile->load(Yii::$app->request->post()))
           {
              $transaction = Yii::$app->getDb()->beginTransaction();
            try {
                if ($user = $userModel->signup($userModel->password_hash)) {
                    $role = Yii::$app->authManager->getRole('cadmin');
                    Yii::$app->authManager->assign($role,$user->id);
                }
                if($userProfile->free_trial == 1)  {
                    $userProfile->free_triel_start_date =Carbon::now();
                    $userProfile->free_triel_end_date =(new Carbon())::now()->addDays(15);
                }
                $userProfile->user_id = $user->id;
                $userProfile->save();

                $transaction->commit();
                return $this->redirect(['auth/login']);
            }catch (DomainException $exception){
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }
        return $this->render('register', [
            'userModel' => new User(),
            'userProfile' =>new CompanyProfile(),
        ]);
    }


    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['admin/']);
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->remove('auth');
        return $this->goHome();
    }

}
