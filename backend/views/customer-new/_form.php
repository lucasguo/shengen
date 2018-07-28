<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-new-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_company')->textInput(['maxlength' => true])->label(\backend\models\CustomerNew::getTypeCompanyLabelFromCode($model->customer_type)) ?>

    <?= $form->field($model, 'customer_job')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= Html::activeHiddenInput($model, 'customer_type') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
