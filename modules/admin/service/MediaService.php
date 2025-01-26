<?php

namespace app\modules\admin\service;

use app\models\Content;
use app\models\Media;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class MediaService
{
    public function actionUpload(UploadedFile $uploadedFile, Content $content)
    {
        $model = new Media();

        $uploadPath = Yii::getAlias('@webroot/uploads/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = uniqid() . '.' . $uploadedFile->extension;
        $filePath = $uploadPath . $fileName;

        if ($uploadedFile->saveAs($filePath)) {
            $model->file_name = sprintf('%s%s'.'%s',  uniqid(),$uploadedFile->name, $uploadedFile->extension);
            $model->file_url = "/uploads/$filePath";
            $model->object_id = $content->id;
            $model->model_class = $content::className();

            if ($model->save(false)) {
                return [
                    'success' => true,
                    'file_url' => $model->file_url,
                ];
            }
        }

        return ['success' => false];
    }
}
