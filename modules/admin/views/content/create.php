<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Content $model */

$this->title = 'Create Content';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">


    <?= $this->render('_form', [
        'content' => $content,
        'info' => $info,
    ]) ?>

</div>
