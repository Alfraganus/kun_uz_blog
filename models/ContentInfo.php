<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "content_info".
 *
 * @property int $id
 * @property int $content_id
 * @property string $language
 * @property string $title
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $content
 * @property string|null $content_blocks
 * @property string|null $meta
 *
 * @property Content $contentParent
 */
class ContentInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_info';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->slug = Inflector::slug($this->title, '-');
            return true; // This is necessary to continue the save process
        }
        return false; // In case parent::beforeSave($insert) returns false
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'language', 'title'], 'required'],
            [['content_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['content_blocks', 'meta'], 'safe'],
            [['language', 'title', 'slug'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Kontent ID'),
            'language' => Yii::t('app', 'Til'),
            'title' => Yii::t('app', 'Sarlavha'),
            'slug' => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Tavsif'),
            'content' => Yii::t('app', 'Kontent'),
            'content_blocks' => Yii::t('app', 'Kontent bloklari'),
            'meta' => Yii::t('app', 'Meta'),
        ];
    }

    /**
     * Gets query for [[Content0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentParent()
    {
        return $this->hasOne(Content::class, ['id' => 'content_id']);
    }
}
