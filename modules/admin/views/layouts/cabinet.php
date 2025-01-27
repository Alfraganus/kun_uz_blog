<?php

use yii\helpers\Html;

\app\assets\CabinetAsset::register($this);
$this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?>kun.uz </title>
    <?php $this->head(); ?>

</head>

<body data-sidebar="dark">
<?php $this->beginBody(); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?= \app\modules\admin\widgets\HeaderWidget::widget(); ?>

    <?= \app\modules\admin\widgets\SidebarWidget::widget(); ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <!--getting all flashes-->
                <?php foreach(Yii::$app->session->getAllFlashes() as $type => $message): ?>
                    <div class="alert alert-<?=$type?>">
                        <strong><?= $message ?>!</strong>
                    </div>
                <?php endforeach ?>

                <?= $content ?>
            </div>
        </div>
    </div>
    <?= \app\modules\admin\widgets\FooterWidget::widget(); ?>


    <?php $this->endBody(); ?>
    <style>
        .input-group-prepend span {
            background: transparent !important;
            color:#212529 !important;
        }

    </style>
</body>

</html>
<?php $this->endPage(); ?>