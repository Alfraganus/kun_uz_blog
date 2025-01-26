<?php

namespace app\modules\admin\controllers;

use app\models\Content;
use app\models\ContentInfo;
use app\models\searchmodel\ContentSearch;
use app\modules\admin\service\ContentService;
use app\modules\admin\service\MediaService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


class ContentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Content models.
     *
     * @return string
     */
    public function actionIndex($type = 'blog')
    {
        if (!in_array($type, ContentService::contentTypes())) {
            throw new NotFoundHttpException('Page not found.');
        }

        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams,$type);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * Displays a single Content model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($type = 'blog')
    {
        if (!in_array($type, ContentService::contentTypes())) {
            throw new NotFoundHttpException('Page not found.');
        }

        $content = new Content();
        $info = new ContentInfo();

        if (Yii::$app->request->isPost) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($content->load(Yii::$app->request->post()) && $info->load(Yii::$app->request->post())) {
                    $content->type = $type;
                    if ($content->save() && $content->validate()) {
                        $info->content_id = $content->id;
                        $info->save();
                        $uploadedFile = UploadedFile::getInstance($content, 'file_name');
                        if ($uploadedFile) {
                            $uploadResult = ( new MediaService())->actionUpload(
                                $uploadedFile,
                                $content
                            );
                            if (!$uploadResult['success']) {
                                throw new \Exception('Failed to upload the file!');
                            }
                            $content->save(false);
                        }

                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $content->id]);
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        } else {
            $content->loadDefaultValues();
        }

        return $this->render('create', [
            'content' => $content,
            'info' => $info,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
