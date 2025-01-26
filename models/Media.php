<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_url
 * @property string|null $model_class
 * @property int $object_id
 * @property string|null $created_at
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'file_url', 'object_id'], 'required'],
            [['object_id'], 'integer'],
            [['created_at'], 'safe'],
            [['file_name', 'file_url', 'model_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'file_url' => 'File Url',
            'model_class' => 'Model Class',
            'object_id' => 'Object ID',
            'created_at' => 'Created At',
        ];
    }
}
