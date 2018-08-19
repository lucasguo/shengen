<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\ProductModel;
use backend\models\CustomerNew;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */

$this->title = '备案单成交';
$this->params['breadcrumbs'][] = ['label' => '备案单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '查看备案单', 'url' => ['view', 'id' => $model->org_order_id]];
$this->params['breadcrumbs'][] = '成交';
?>
<div class="order-new-update">

    <div class="box">
    	<div class="box-body">
            <div class="order-new-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'model_id')->widget(Select2::classname(), [
                    'data' => ProductModel::getAllProductModels(),
                    'options' => ['placeholder' => '选择型号'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

                <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
                    'data' => CustomerNew::getAllCustomers(),
                    'options' => ['placeholder' => '选择客户'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

                <?= $form->field($model, 'sell_count')->textInput() ?>

                <?= $form->field($model, 'sell_amount')->textInput() ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('成交', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
    	</div>
    </div>

</div>
