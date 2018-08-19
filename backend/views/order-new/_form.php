<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\models\ProductModel;
use backend\models\CustomerNew;
use backend\models\OrderNew;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-new-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model_id')->widget(Select2::classname(), [
        'data' => ProductModel::getAllProductModels(),
        'options' => ['placeholder' => '选择型号'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'sell_count')->textInput() ?>

    <?php if ($model->order_status == OrderNew::STATUS_DEAL) {
       echo   $form->field($model, 'sell_amount')->textInput();
    }?>

    <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
        'data' => CustomerNew::getAllCustomers(),
        'options' => ['placeholder' => '选择客户'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
