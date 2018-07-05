<?php
use yii\helpers\Html;
use backend\models\MeetingRecord;


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['meeting-record/index']);
?>
<div class="password-reset">
    <p>您好，<?= Html::encode($username) ?>,</p>

<?php if($record->file_type == MeetingRecord::FILE_TYPE_MEETING) {?>
    <p>附件为圣恩<?=$record->meeting_date ?>内部会议记录，请查收。</p>
<?php } else {?>
	<p>附件是主题为（<?=$record->topic ?>）的内部文件，请查收。</p>
<?php } ?>
    <p>或者通过下列链接访问:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    
    <p>此邮件为系统自动生成，请勿回复。</p>
</div>
