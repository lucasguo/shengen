<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResetPasswordForm */
/* @var $form ActiveForm */
$this->title = "修改资料";
?>
<div class="reset">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['disabled' => 'disabled']) ?>
        <?= $form->field($model, 'mobile')->textInput(['disabled' => 'disabled']) ?>
        <?= $form->field($model, 'email')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div><!-- reset -->
