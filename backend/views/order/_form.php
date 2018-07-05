<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\PopupInput;
use backend\models\Customer;
use backend\models\MachineMaster;
use yii\web\View;
use backend\models\OrderMaster;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $customerInitValue = "";
    if(!empty($model->customer_id))
    {
    	$customerInitValue = Customer::findOne($model->customer_id)->customer_name;
    }
    echo $form->field($model, 'customer_id')->widget(PopupInput::className(), [
    	'popupUrl' => 'lookup/all-customer',
    	'jsCallback' => 'updateCustomer',
    	'textId' => 'customerValue',
    	'hiddenId' => 'customerId',
    	'textValue' => $customerInitValue,
    ]);
    ?>

    <?php
    if($model->order_status == OrderMaster::STATUS_COLLECTED) {
    	echo $form->field($model, 'sold_count')->textInput(); 
    } else {
    	echo $form->field($model, 'sold_count')->textInput(['disabled' => 'disabled']);
    }
    ?>

    <?= $form->field($model, 'sold_amount')->textInput([
    	'maxlength' => true,
    ]) ?>
    
    <?php 
    if($model->isNewRecord) {
    	echo $form->field($model, 'add_to_finance')->checkbox();
    }
    ?>

    <?= $form->field($model, 'soldDate')->textInput([
    	'type' => 'date'
    ]) ?>

    <?= $form->field($model, 'need_invoice')->dropDownList(['0' => '否', '1' => '是']) ?>

    <?= $form->field($model, 'warranty_in_month')->textInput([
    	'type' => 'number'
    ]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$script = <<<JS
function updateCustomer(data) {
	\$("#customerValue").val(data.value);
	\$("#customerId").val(data.id);
}
// function updateMachine(data) {
// 	\$("#machineValue").val(data.value);
// 	\$("#machineId").val(data.id);
// }
JS;
$this->registerJs($script, View::POS_BEGIN);
?>