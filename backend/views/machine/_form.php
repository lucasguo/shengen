<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="machine-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'machine_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'machine_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_datetime')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
