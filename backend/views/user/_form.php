<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'mobile')->textInput() ?>
    <?= $form->field($model, 'roles')->checkboxList(User::getAllRoles()) ?>

            <div id="shop-popup">
            <?= $form->field($model, 'shop_id')->widget("backend\widgets\PopupInput", [
                "popupUrl" => "lookup/all-shop",
                "jsCallback" => "updateShop",
                "textId" => "shopName",
                "hiddenId" => "shopId",
                "textValue" => $shopName,
            ])?>
                <?=Html::a('点击此处', \yii\helpers\Url::to(['dealer-shop/create'])) ?>添加门店
            </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div>

<?php
$functionScript = <<<JS
function updateShop(data) {
    $("#shopName").val(data.value);
    $("#shopId").val(data.id);
}
function toggleShop() {
	if ($("input[value='dealer']").is(':checked') || $("input[value='dealerEmployee']").is(':checked')) {
		$('#shop-popup').show();
	} else {
		$('#shop-popup').hide();
	}
}
JS;
$this->registerJs($functionScript, View::POS_BEGIN);
$script = <<<JS
toggleShop();
$("input[value='dealer']").change(function(){
	toggleShop();
});
$("input[value='dealerEmployee']").change(function(){
	toggleShop();
});
JS;
$this->registerJs($script);
?>
