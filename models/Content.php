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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->slug = Inflector::slug($this->type, '-');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'is_deleted', 'cacheable', 'created_by', 'updated_by', 'content_category_id '], 'integer'],
            [['type', 'created_on', 'updated_on'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'cacheable' => Yii::t('app', 'Cacheable'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by' => Yii::t('app', 'Updated By'),
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
