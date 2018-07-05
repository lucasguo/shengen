<?php
use yii\helpers\Html;
use backend\models\MeetingRecord;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['meeting-record/index']);
?>
您好，<?= Html::encode($username) ?>,

<?php if($record->file_type == MeetingRecord::FILE_TYPE_MEETING) {?>
附件为圣恩<?=$record->meeting_date ?>内部会议记录，请查收。
<?php } else {?>
附件是主题为（<?=$record->topic ?>）的内部文件，请查收。
<?php } ?>
    
或者通过下列链接访问:

<?= $resetLink ?>
    
此邮件为系统自动生成，请勿回复。
