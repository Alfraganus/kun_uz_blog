<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string|null $type
 * @property int|null $status
 * @property int|null $is_deleted
 * @property int|null $cacheable
 * @property string|null $created_on
 * @property int|null $created_by
 * @property string|null $updated_on
 * @property int|null $updated_by
 * @property int|null $content_category_id
 *
 * @property ContentInfo[] $contentInfos
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    public $file_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'is_deleted', 'cacheable', 'created_by', 'updated_by', 'content_category_id'], 'integer'],
            [['type', 'created_on', 'updated_on'], 'string', 'max' => 255],
            [['file_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_name' => Yii::t('app', 'Rasm'),
            'type' => Yii::t('app', 'Turi'),
            'status' => Yii::t('app', 'Holati'),
            'is_deleted' => Yii::t('app', 'O‘chirildi'),
            'cacheable' => Yii::t('app', 'Keshlash mumkin'),
            'created_on' => Yii::t('app', 'Yaratilgan sana'),
            'created_by' => Yii::t('app', 'Kim tomonidan yaratilgan'),
            'updated_on' => Yii::t('app', 'Yangilangan sana'),
            'updated_by' => Yii::t('app', 'Kim tomonidan yangilangan'),
        ];
    }

    /**
     * Gets query for [[ContentInfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentInfos()
    {
        return $this->hasMany(ContentInfo::class, ['content_id' => 'id']);
    }

    public function getContentCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'content_category_id']);
    }
}
