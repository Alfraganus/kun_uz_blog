<?php
namespace app\modules\admin\service;

use app\models\User;
use Yii;

class  UserService {

    public static function getUser($attribute) : String
    {
        return Yii::$app->user->identity->$attribute;
    }

}