<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model \backend\models\AmendForm */

$this->title = '维修仪器' . $machineSn;
if ($fromPart) {
    $this->params['breadcrumbs'][] = ['label' => '配件管理', 'url' => ['index']];
} else {
    $this->params['breadcrumbs'][] = ['label' => '仪器管理', 'url' => ['/machine/index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-amend">

    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'amendType')->dropDownList(\backend\models\AmendRecord::getTypeList(), ['id' => 'amendType']) ?>

            <?= $form->field($model, 'oldPartId')->dropDownList($partOptions, ['id' => 'oldPartId']) ?>

            <div id="newPartSn">
            <?= $form->field($model, 'newPartSn')->textInput() ?>
            </div>

            <?= $form->field($model, 'comment')->textarea() ?>

            <div class="form-group">
                <?= Html::submitButton('添加', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php
$replaceType = \backend\models\AmendRecord::TYPE_REPLACE;
$partOther = \backend\models\AmendRecord::PART_OTHER;
$partOtherName = \backend\models\AmendRecord::PART_OTHER_NAME;
$functionScript = <<<JS
function toggleNewPart() {
	if ($('#amendType').val() == $replaceType) {
		$('#newPartSn').show();
		$("#oldPartId option[value=$partOther]").remove();
	} else {
		$('#newPartSn').hide();
		$("#oldPartId").append("<option value='$partOther'>$partOtherName</option>");
	}
}
JS;
$this->registerJs($functionScript, View::POS_BEGIN);
$script = <<<JS
toggleNewPart();
$('#amendType').change(function(){
	toggleNewPart();
});
JS;
$this->registerJs($script);
?>
