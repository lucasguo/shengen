<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResetPasswordForm */
/* @var $form ActiveForm */
$this->title = "修改密码";
?>
<div class="reset">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oldPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div><!-- reset -->
