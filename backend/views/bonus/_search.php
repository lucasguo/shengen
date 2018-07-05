<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BonusSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bonus-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'single_price') ?>

    <?= $form->field($model, 'once_return') ?>

    <?= $form->field($model, 'sale_bonus') ?>

    <?= $form->field($model, 'manage_bonus') ?>

    <?php // echo $form->field($model, 'level_limit') ?>

    <?php // echo $form->field($model, 'return_day_limit') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
