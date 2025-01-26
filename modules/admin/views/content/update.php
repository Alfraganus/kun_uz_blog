<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Content $model */

$this->title = 'Update Content: ' . $content->id;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $content->id, 'url' => ['view', 'id' => $content->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="content-update">


    <?= $this->render('_form', [
        'content' => $content,
        'info' => $info,
        'lang' => $lang,
        'type' => $type,
    ]) ?>

</div>
