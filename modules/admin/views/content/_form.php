<?php

use app\models\Categories;
use app\models\User;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\Accordion;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $content Content */
/* @var $info ContentInfo */

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-9">
                <!-- Main Form Section -->
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form'],
                    'fieldConfig' => [
                        'options' => ['class' => 'form-group'],
                        'inputOptions' => ['class' => 'form-control'],
                        'labelOptions' => ['class' => 'form-label'],
                        'template' => "{label}\n{input}\n<small class='form-text text-muted'>{hint}</small>\n{error}", // Match Bootstrap hint style
                    ],
                ]); ?>

                <!-- Accordion for Sections -->
                <?= Accordion::widget([
                    'items' => [
                        [
                            'label' => 'General Information',
                            'content' =>
                                $form->field($info, 'title')->textInput(['maxlength' => true]) .
                                $form->field($info, 'description')->textarea(['rows' => 4]) .
                                $form->field($info, 'content')->textarea(['rows' => 6]),

                        ],
                        [
                            'label' => 'Metadata',
                            'content' =>
                                $form->field($info, 'content_blocks')->textarea(['rows' => 4]) .
                                $form->field($info, 'meta')->textarea(['rows' => 3]),
                            'options' => ['id' => 'metadata'],
                        ],


                    ],
                ]) ?>

                <!-- Submit Button -->
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    <!-- Apply primary Bootstrap button -->
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-3">
                <!-- Sidebar -->
                <div class="card">
                    <div class="card-body">
                        <?= $form->field($content, 'author_id')->dropDownList(ArrayHelper::map(
                            User::find()->all(), 'id', 'username'
                        )); ?>

                        <?= $form->field($content, 'content_category_id')->dropDownList(ArrayHelper::map(
                            Categories::find()->where(['category_type' => $type])->all(), 'id', 'category_name'
                        )) ?>
                        <?= $form->field($content, 'status')->dropDownList(
                                [1 => 'Active', 0 => 'Inactive'], ['class' => 'form-control']);
                       ?>
                        <?= $form->field($info, 'language')->dropDownList(
                            [1 => 'Active', 0 => 'Inactive'], ['class' => 'form-control']);
                        ?>

                        <?= $form->field($content, 'file_name')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                            'pluginOptions' => [
                                'allowedFileExtensions' => ['jpg', 'png', 'jpeg', 'gif'],
                                'maxFileSize' => 2000, // 2MB
                                'showUpload' => true,
                                'showRemove' => true,
                                'uploadUrl' => Url::to(['media/upload']),
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>