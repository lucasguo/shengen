<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\MachineProduct;
use backend\models\ProductForm;
use backend\widgets\PopupInput;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $prodForm backend\models\ProductForm */
?>

<div class="machine-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'product_status')->dropDownList(MachineProduct::getStatusList()) ?>
    
    <?= $form->field($prodForm, 'partType1')->widget("backend\widgets\PopupInput", [
    	"popupUrl" => "lookup/part-type",
    	"jsCallback" => "updatePartType1",
    	"textId" => "type1name",
    	"hiddenId" => "type1id",
    	"textValue" => $prodForm->getPartTypeName(1),
    ])?>
    
    <?= $form->field($prodForm, 'partType2')->widget("backend\widgets\PopupInput", [
    	"popupUrl" => "lookup/part-type",
    	"jsCallback" => "updatePartType2",
    	"textId" => "type2name",
    	"hiddenId" => "type2id",
    	"textValue" => $prodForm->getPartTypeName(2),
    ])?>
    
    <?= $form->field($prodForm, 'partType3')->widget("backend\widgets\PopupInput", [
    	"popupUrl" => "lookup/part-type",
    	"jsCallback" => "updatePartType3",
    	"textId" => "type3name",
    	"hiddenId" => "type3id",
    	"textValue" => $prodForm->getPartTypeName(3),
    ])?>
    
    <?= $form->field($prodForm, 'partType4')->widget("backend\widgets\PopupInput", [
    	"popupUrl" => "lookup/part-type",
    	"jsCallback" => "updatePartType4",
    	"textId" => "type4name",
    	"hiddenId" => "type4id",
    	"textValue" => $prodForm->getPartTypeName(4),
    ])?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = <<<JS
function updatePartType1(data) {
	\$("#type1name").val(data.value);
	\$("#type1id").val(data.id);
}
function updatePartType2(data) {
	\$("#type2name").val(data.value);
	\$("#type2id").val(data.id);
}
function updatePartType3(data) {
	\$("#type3name").val(data.value);
	\$("#type3id").val(data.id);
}
function updatePartType4(data) {
	\$("#type4name").val(data.value);
	\$("#type4id").val(data.id);
}
JS;
$this->registerJs($script, View::POS_BEGIN);
?>
