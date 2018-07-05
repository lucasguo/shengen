<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Customer;
use common\models\User;
use backend\widgets\PopupInput;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'customer_type')->dropDownList(Customer::getTypeList(), ['id'=>'type']) ?>
	<div id="customer_corp">
    <?= $form->field($model, 'customer_corp')->textInput(['maxlength' => true]) ?>
    </div>
    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_address')->textarea(['rows' => 6]) ?>
    
    <?php if(\Yii::$app->user->can('updateCustomer') && !$model->isNewRecord) {?>
    
    <?= $form->field($model, 'belongto')->widget(PopupInput::className(), [
    	'popupUrl' => 'lookup/all-salesman',
    	'jsCallback' => 'updateSalesman',
    	'textId' => 'userTextId',
    	'hiddenId' => 'userHiddenId',
    	'textValue' => $model->getBelongtoUsername(),
    ]) ?>
    
    <?php }?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
if(\Yii::$app->user->can('updateCustomer') && !$model->isNewRecord) {
	$script = <<<JS
	function updateSalesman(data) {
		$("#userTextId").val(data.value);
		$("#userHiddenId").val(data.id);
	}
JS;
	$this->registerJs($script, View::POS_BEGIN);
}
$functionScript = <<<JS
function toggleCustomerCorp() {
	if ($('#type').val() == 1) {
		$('#customer_corp').show();
	} else {
		$('#customer_corp').hide();
	}
}
JS;
$this->registerJs($functionScript, View::POS_BEGIN);
$script = <<<JS
toggleCustomerCorp();
$('#type').change(function(){
	toggleCustomerCorp();
});
JS;
$this->registerJs($script);
?>
