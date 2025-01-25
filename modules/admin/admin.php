<?php

namespace app\modules\admin;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class admin extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['auth/login'])->send();
            return false;
        }
        return parent::beforeAction($action);
    }


    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->layout = 'cabinet';
        parent::init();

    }
}
