<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Finance;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Finance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
	if($type > 0) {
		$typelist = Finance::getIncomingTypeList();
	} else {
		$typelist = Finance::getOutgoingTypeList();
	}
    echo $form->field($model, 'type')->dropDownList($typelist); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'occur_date')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'userid')->dropDownList(User::getAllUserList(), ['prompt' => '无']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
