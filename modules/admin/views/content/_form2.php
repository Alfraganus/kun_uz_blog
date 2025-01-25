<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Accordion;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

/* @var $this yii\web\View */
/* @var $content Content */
/* @var $info ContentInfo */  // Correct the variable to ContentInfo if it's the related model
?>

<div class="row">

    <div class="col-md-9">
        <!-- Main Form Section -->
        <?php $form = ActiveForm::begin(); ?>

        <!-- Accordion for Sections -->
        <?= Accordion::widget([
            'items' => [
                [
                    'label' => 'General Information',
                    'content' => $form->field($info, 'slug')->textInput(['maxlength' => true]) .
                        $form->field($info, 'title')->textInput(['maxlength' => true]) .
                        $form->field($content, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive']),
                    'options' => ['id' => 'general'],
                ],
                [
                    'label' => 'Metadata',
                    'content' => $form->field($content, 'created_on')->input('date') .
                        $form->field($content, 'created_by')->textInput() .
                        $form->field($content, 'updated_on')->input('date') .
                        $form->field($content, 'updated_by')->textInput(),
                    'options' => ['id' => 'metadata'],
                ],
                [
                    'label' => 'Content',
                    'content' => $form->field($info, 'language')->textInput() .
                        $form->field($info, 'description')->textarea(['rows' => 4]) .
                        $form->field($info, 'content')->textarea(['rows' => 6]),
                    'options' => ['id' => 'content'],
                ],
                [
                    'label' => 'Additional Fields',
                    'content' => $form->field($info, 'content_blocks')->textarea(['rows' => 4]) .
                        $form->field($info, 'meta')->textarea(['rows' => 3]),
                    'options' => ['id' => 'additional-fields'],
                ],
            ],
        ]) ?>

        <!-- Submit Button -->
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-3">
        <!-- Sidebar -->
        <div class="card">
            <div class="card-body">
               <?=   $form->field($content, 'author_id')->textInput()?>
            </div>
        </div>
    </div>

</div>
