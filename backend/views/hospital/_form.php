<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Hospital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hospital-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hospital_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hospital_city')->widget(Select2::classname(), [
        'data' => \backend\models\Region::getFujianCities(),
        'options' => ['placeholder' => '选择一个城市'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>


    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
