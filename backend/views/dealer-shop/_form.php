<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Region;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\DealerShop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dealer-shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    if ($model->opener != null) {
        $salesmanName = $model->opener->username;
    } else {
        $salesmanName = '';
    }
    ?>
    <?= $form->field($model, 'user_id')->widget("backend\widgets\PopupInput", [
        "popupUrl" => "lookup/all-salesman",
        "jsCallback" => "updateSalesman",
        "textId" => "salesmanName",
        "hiddenId" => "salesmanId",
        "textValue" => $salesmanName,
    ])?>

	<?php 
	$url=\yii\helpers\Url::toRoute(['dealer-shop/get-region']);
	
	echo $form->field($model, 'province')->widget(\chenkby\region\Region::className(),[
	    'model'=>$model,
	    'url'=>$url,
	    'province'=>[
	        'attribute'=>'province',
	        'items'=>Region::getRegion(),
	        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
	    ],
	    'city'=>[
	        'attribute'=>'city',
	        'items'=>Region::getRegion($model['province']),
	        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
	    ],
	    'district'=>[
	        'attribute'=>'region',
	        'items'=>Region::getRegion($model['city']),
	        'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
	    ]
	])->label('所在地区');
	?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
function updateSalesman(data) {
	$("#salesmanName").val(data.value);
	$("#salesmanId").val(data.id);
}
JS;
$this->registerJs($script, View::POS_BEGIN);
?>
