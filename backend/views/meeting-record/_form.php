<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use backend\models\MeetingRecord;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\MeetingRecordForm */
/* @var $form ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'fileType')->dropDownList(MeetingRecord::getFileTypeList(), ['id' => 'file-type-input']) ?>
		<div id="meeting-date-input">
        <?= $form->field($model, 'meetingDate')->textInput(['type' => 'date']) ?>
        </div>
        <?= $form->field($model, 'file')->fileInput() ?>
        <?= $form->field($model, 'topic')->textarea() ?>
        <?= $form->field($model, 'noticeUsers')->checkboxList(User::getAllCoreMember()) ?>
    
        <div class="form-group text-center">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    
<?php 
$meetingType = MeetingRecord::FILE_TYPE_MEETING;
$function = <<<JS
function updateInputStatus() {
	if($("#file-type-input").val() == $meetingType) {
		$("#meeting-date-input").show();
	} else {
		$("#meeting-date-input").hide();
	}
}
JS;
$script = <<<JS
updateInputStatus();
$("#file-type-input").change(function(){
	updateInputStatus();
});
JS;
$this->registerJs($function, View::POS_HEAD);
$this->registerJs($script);
?>

