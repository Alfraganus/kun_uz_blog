<?php

use app\models\Categories;
use app\models\User;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
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
                    'options' => [
                        'class' => 'form',
                        'enctype' => 'multipart/form-data',
                    ],
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
                                $form->field($info, 'content')->widget(CKEditor::className(), [
                                    'editorOptions' => [
                                        'preset' => 'standard',
                                        'inline' => false,
                                        'height' => 300,
                                        'allowedContent' => true,
                                    ],
                                ]),

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
                        <?php if ($content->isNewRecord): ?>
                            <?= $form->field($info, 'language')->dropDownList(Yii::$app->params['languages']); ?>
                        <?php else: ?>
                            <?= $form->field($info, 'language')->textInput([
                                'value' => $lang,
                                'readonly' => true,
                            ]); ?>
                        <?php endif; ?>

                        <center>
                            <div class="image-preview">
                                <?php if ($content->media && isset($content->media->file_name)): ?>
                                    <img id="image-preview"
                                         src="/uploads/<?= $content->media->file_name ?>"
                                         alt="Image preview"
                                         style="max-width: 200px; max-height: 200px;" />
                                <?php else: ?>
                                    <img id="image-preview"
                                         src="#"
                                         alt="Image preview"
                                         style="max-width: 200px; max-height: 200px; display: none;" />
                                <?php endif; ?>
                            </div>
                        </center>
                        <?= $form->field($content, "file_name")->fileInput(['id' => 'file-input', 'accept' => 'image/*']); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section



<?php
$this->registerJs("
    document.getElementById('file-input').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; 
            };
            reader.readAsDataURL(file);
        }
    });
", \yii\web\View::POS_END);
?>