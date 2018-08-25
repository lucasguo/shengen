<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-new-form">

    <?php
    $form = ActiveForm::begin();
    $hospitalField = $model->customer_type == \backend\models\CustomerNew::TYPE_COMPANY ? 'hospital_ids' : 'hospital_id';
    ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_id')->widget(Select2::classname(), [
        'data' => \backend\models\Region::getFujianCities(),
        'options' => ['placeholder' => '选择城市'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, $hospitalField)->widget(Select2::classname(), [
        'data' => \backend\models\Hospital::getHospitalList(),
        'options' => ['placeholder' => '选择医院', 'multiple' => $model->customer_type == \backend\models\CustomerNew::TYPE_COMPANY],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'customer_company')->textInput(['maxlength' => true])->label(\backend\models\CustomerNew::getTypeCompanyLabelFromCode($model->customer_type)) ?>



    <?php if ($model->customer_type == \backend\models\CustomerNew::TYPE_PATIENT) { ?>
        <?= $form->field($extend, 'gender')->dropDownList(\backend\models\CustomerNewExtend::getGenderList()) ?>
        <?= $form->field($extend, 'age')->textInput(['maxlength' => true]) ?>
        <?= $form->field($extend, 'diagnosis')->textInput(['maxlength' => true]) ?>
        <?= $form->field($extend, 'disease_course')->textInput(['maxlength' => true]) ?>
        <?= $form->field($extend, 'doctor_id')->widget(Select2::classname(), [
            'data' => \backend\models\CustomerNew::getAllDoctors(),
            'options' => ['placeholder' => '选择专家'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($extend, 'treat_plan')->textInput(['maxlength' => true]) ?>

    <?php } else { ?>
        <?= $form->field($model, 'customer_job')->textInput(['maxlength' => true]) ?>
    <?php } ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>

    <?= Html::activeHiddenInput($model, 'customer_type') ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
