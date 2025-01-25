<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span class="logo_title mt-5"> kun.uz Access board </span>
            <?php if(Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-warning">
                    <strong>Warning! </strong>  Someone has logged in from this account
                </div>
            <?php endif;?>

        </div>
        <div class="card-body">
            <form action="" method="post">
                <?= $form->field($model, 'username')->textInput(['placeholder' =>'login',['class'=>'input-group-prepend']])->label(false) ?>
                <?= $form->field($model, 'password')->textInput(['placeholder' =>'password',['class'=>'input-group-prepend']])->label(false) ?>

                <div class="form-group">
                    <input type="submit" name="btn" value="Login" class="btn btn-outline-danger float-right login_btn">
                </div>

            </form>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
    .help-block {
        color: aliceblue !important;
    }
</style>
