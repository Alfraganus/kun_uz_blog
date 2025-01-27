<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Content $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'type',
            [
                'label' => Yii::t('app', 'Title'),
                'value' => function ($model) {
                    return $model->contentInfos ? $model->contentInfos[0]->title : '';
                },
            ],
            [
                'label' => Yii::t('app', 'Kategoriya'),
                'value' => function ($model) {
                    return $model->contentCategory ? $model->contentCategory->category_name : Yii::t('app', 'Not set');
                },
            ],
            'status',
            [
                'label' => Yii::t('app', 'Kim tomonidan kiritilgan'),
                'value' => function ($model) {
                    return $model->created_by  ? $model->createdBy->username : '';
                },
            ],
            [
                'label' =>'Avtor',
                'value' => function ($model) {
                    return $model->author_id  ? $model->author->username : '';
                },
            ],
            'created_on',

        ],
    ]) ?>

</div>
