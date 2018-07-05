<?php

use yii\helpers\Html;
use backend\models\MachineMaster;
use yii\widgets\ActiveForm;
use backend\widgets\PopupInput;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model backend\models\OutOrderForm */

$this->title = '订单出库:' . $orderSn;
$this->params['breadcrumbs'][] = ['label' => '订单出库', 'url' => ['out-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-out-create">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    $index = 0;
    foreach ($model->machines as $machineId) {
    	$machineInitValue = "";
    	if(!empty($machineId))
    	{
    		$machineInitValue = MachineMaster::findOne($machineId)->machine_sn;
    	}
    	echo $form->field($model, 'machines['.$index.']')->widget(PopupInput::className(), [
    		'popupUrl' => 'lookup/machine-in-house',
    		'jsCallback' => 'updateMachine(' . $index . ', data)',
    		'textId' => 'machine' . $index . 'Value',
    		'hiddenId' => 'machine' . $index . 'Id',
    		'textValue' => $machineInitValue,
    	]);
    	$index ++;
    }

    ?>

    <div class="form-group">
        <?= Html::submitButton('出库', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div>
<?php 
$script = <<<JS
function updateMachine(index, data) {
	\$("#machine" + index + "Value").val(data.value);
	\$("#machine" + index + "Id").val(data.id);
}
JS;
$this->registerJs($script, View::POS_BEGIN);
?>