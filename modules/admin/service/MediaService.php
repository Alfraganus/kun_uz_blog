<?php
namespace app\modules\admin\service;

use app\models\Media;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class MediaService {
    public function actionUpload(UploadedFile $uploadedFile, Model $model)
    {
        $model = new Media();

        if (Yii::$app->request->isPost) {
            $uploadedFile = UploadedFile::getInstanceByName('file');

            if ($uploadedFile) {
                $uploadPath = Yii::getAlias('@webroot/uploads/');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadPath . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $model->file_name = $uploadedFile->name;
                    $model->file_url = Yii::getAlias('@web/uploads/') . $fileName;
                    $model->object_id =null;
                    $model->model_class =null;

                    if ($model->save()) {
                        return [
                            'success' => true,
                            'file_url' => $model->file_url,
                        ];
                    }
                }
            }
        }

        return ['success' => false];
    }
}
