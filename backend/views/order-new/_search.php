<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\OrderNew;
use backend\models\ProductModel;
use backend\models\CustomerNew;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-new-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'model_list')->widget(Select2::classname(), [
        'data' => ProductModel::getAllProductModels(),
        'options' => ['placeholder' => '选择型号', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'customer_list')->widget(Select2::classname(), [
        'data' => CustomerNew::getAllCustomers(),
        'options' => ['placeholder' => '选择客户', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'order_status')->dropDownList(OrderNew::getStatusList()) ?>


    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
