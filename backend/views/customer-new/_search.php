<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

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

    <?= $form->field($model, 'customer_company')->label(\backend\models\CustomerNew::getTypeCompanyLabelFromCode($type)) ?>

    <?= $form->field($model, 'hospital_list')->widget(Select2::classname(), [
        'data' => \backend\models\Hospital::getHospitalList(),
        'options' => ['placeholder' => '选择医院', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'over_month')->dropDownList(\backend\models\CustomerNewSearch::getMonthList(), ['prompt' => '请选择']) ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
