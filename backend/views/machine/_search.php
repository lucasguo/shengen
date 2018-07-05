<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="machine-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'machine_sn') ?>

    <?= $form->field($model, 'machine_cost') ?>

    <?= $form->field($model, 'machine_status') ?>

    <?php // echo $form->field($model, 'in_datetime') ?>

    <?php // echo $form->field($model, 'out_datetime') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
