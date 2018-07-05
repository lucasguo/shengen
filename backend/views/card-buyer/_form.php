<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardBuyer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-buyer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'buyername')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->inline()->radioList(\backend\models\CardBuyer::getSexList()) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro_type')->dropDownList(\backend\models\CardBuyer::getIntroList(), ['id' => 'intro_type']) ?>

    <div id="intro_name">
    <?= $form->field($model, 'intro_name')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'symptom')->inline()->radioList(\backend\models\Symptom::getSymptomList(), ['id' => 'symptom']) ?>

    <div id="other_symptom">
    <?= $form->field($model, 'other_symptom')->textInput(['maxlength' => true])->label('') ?>
    </div>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'cardType')->dropDownList(\backend\models\CardType::getAllCardTypes());
        echo $form->field($model, 'cardNo')->textInput(['maxlength' => true]);
    }
    ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$otherId = \backend\models\Symptom::OTHER_SYMPTON_ID;
$noneType = \backend\models\CardBuyer::INTRO_NONE;
$functionScript = <<<JS
function toggleOtherSymptom() {
    if ($('input[type=radio][name="CollectCardBuyerForm[symptom]"]:checked').val() == $otherId || $('input[type=radio][name="CardBuyer[symptom]"]:checked').val() == $otherId) {
        $('#other_symptom').show();
    } else {
        $('#other_symptom').hide();
    }
}
function toggleIntroName() {
    if ($('#intro_type').val() != $noneType) {
        $('#intro_name').show();
    } else {
        $('#intro_name').hide();
    }
}
JS;
$this->registerJs($functionScript, \yii\web\View::POS_BEGIN);
$script = <<<JS
toggleOtherSymptom();
toggleIntroName();
$('input[type=radio][name="CollectCardBuyerForm[symptom]"]').change(function() {
    toggleOtherSymptom();
});
$('input[type=radio][name="CardBuyer[symptom]"]').change(function() {
    toggleOtherSymptom();
});
$('#intro_type').change(function() {
    toggleIntroName();
});
JS;
$this->registerJs($script);

