<?php

use app\models\Content;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\searchmodel\ContentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
$languages = Yii::$app->params['languages'];
$currentLanguage = Yii::$app->language;
?>
<div class="content-index">


    <p>
        <?= Html::a(Html::encode($type)." yaratish", ['create','type'=>Html::encode($type)], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => Yii::t('app', 'Image'),
                'value' => function ($model) {
                    $media = $model->media;
                    if ($media) {
                        return Html::img(sprintf('/uploads/%s',$media->file_name), ['width' => '100px', 'height' => '100px']);
                    }
                    return Html::img(sprintf('/images/nophoto.avif'),['width' => '100px', 'height' => '100px']);
                },
                'format' => 'raw',
            ],
            [
                'label' => Yii::t('app', 'Sarloha'),
                'value' => function ($model) {
                    return $model->contentInfos ? $model->contentInfos[0]->title : '';
                },
            ],

            [
                'attribute' => 'content_category_id',
                'label' => Yii::t('app', 'Kategoriya'),
                'value' => function ($model) {
                    return $model->contentCategory ? $model->contentCategory->category_name : Yii::t('app', 'Not set');
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'content_category_id',
                   ArrayHelper::map(\app\models\Categories::find()->all(), 'id', 'category_name'),
                    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Kategoriya tanlang')]
                ),
            ],
            [
                'attribute' => 'created_by',
                'label' => Yii::t('app', 'Kim tomonidan kiritilgan'),
                'value' => function ($model) {
                    return $model->created_by ? $model->createdBy->username : '';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'created_by',
                    ArrayHelper::map(User::find()->all(), 'id', 'username'),
                    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Foydalanuvchi tanlang')]
                ),
            ],
            [
                'attribute' => 'author_id',
                'label' => 'Avtor',
                'value' => function ($model) {
                    return $model->author_id ? $model->author->username : '';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'author_id',
                    ArrayHelper::map(User::find()->all(), 'id', 'username'),
                    ['class' => 'form-control', 'prompt' => Yii::t('app', 'Foydalanuvchi tanlang')]
                ),
            ],
            'created_on',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete} {languages}',
                'buttons' => [
                    'languages' => function ($url, $model, $key) {
                        $languages = Yii::$app->params['languages'];
                        $filledLanguages = ArrayHelper::getColumn($model->contentInfos, 'language');
                        $buttons = '';

                        foreach ($languages as $langKey => $langName) {
                            if (in_array($langKey, $filledLanguages)) {
                                $buttons .= Html::a(
                                    Yii::t('app', $langName),
                                    ['update',
                                        'id' => $model->id,
                                        'lang' => $langKey,
                                        'type' => 'blog'
                                    ],
                                    [
                                        'class' => 'btn btn-success btn-sm',
                                        'style' => 'margin: 2px;',
                                        'title' => Yii::t('app', 'Edit Language Content'),
                                    ]
                                );
                            } else {
                                $buttons .= Html::a(
                                    Yii::t('app', $langName),
                                    ['update',
                                        'id' => $model->id,
                                        'lang' => $langKey,
                                        'type' => 'blog'
                                    ],
                                    [
                                        'class' => 'btn btn-secondary btn-sm',
                                        'style' => 'margin: 2px;',
                                        'title' => Yii::t('app', 'Add Language Content'),
                                    ]
                                );
                            }
                        }

                        return $buttons;
                    },
                ],
                'urlCreator' => function ($action, Content $model, $key, $index, $column) use ($type) {
                    return Url::toRoute([$action,'id'=>$model->id, 'type' =>$type]);
                },
            ],
        ],
    ]); ?>


</div>
