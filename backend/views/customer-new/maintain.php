<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerMaintainForm */
/* @var $form ActiveForm */
$this->title = "添加维护记录： " . $customerName;
?>
<div class="customer-maintain">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->textarea() ?>
        <?= $form->field($model, 'add_alert')->checkbox(['id' => 'add_alert']); ?>
        <div id="alert-area">
        <?= $form->field($model, 'alert_date')->textInput(['type' => 'date']) ?>
        <?= $form->field($model, 'alert_time')->dropDownList(\backend\models\CustomerMaintainNewForm::TIME_LIST) ?>
        <?= $form->field($model, 'alert_content')->textarea() ?>
        </div>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div><!-- customer-maintain -->

<?php 
$script = <<<JS
if($('#add_alert').is(':checked')) {
	$('#alert-area').show();
} else {
	$('#alert-area').hide();
}
		

$('#add_alert').change(function(){
	if($('#add_alert').is(':checked')) {
		$('#alert-area').show();
	} else {
		$('#alert-area').hide();
	}
});
JS;
$this->registerJs($script);
?>
