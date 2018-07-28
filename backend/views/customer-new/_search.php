<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-new-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index', 'type' => $type],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'customer_name') ?>

    <?= $form->field($model, 'customer_mobile') ?>

    <?= $form->field($model, 'customer_company') ?>

    <?= $form->field($model, 'customer_job') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
