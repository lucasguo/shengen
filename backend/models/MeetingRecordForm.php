<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\UploadedFile;

class MeetingRecordForm extends Model
{
	const FILE_FOLDER = "uploads/meetings/";
	
	public $topic;
	public $fileType;
	public $meetingDate;
	/**
	 * 
	 * @var UploadedFile
	 */
	public $file;
	public $noticeUsers;
	
	public function rules()
	{
		return [
			['fileType', 'default', 'value' => MeetingRecord::FILE_TYPE_MEETING],
            ['fileType', 'in', 'range' => [MeetingRecord::FILE_TYPE_MEETING, MeetingRecord::FILE_TYPE_OTHER, MeetingRecord::FILE_MONTHLY_REPORT, MeetingRecord::FILE_MONTHLY_SCHEDULE]],
			[['meetingDate', 'topic'], 'string'],
			['meetingDate', 'required', 'when' => function ($model) { return $model->fileType == MeetingRecord::FILE_TYPE_MEETING; }, 'whenClient' => "function (attribute, value) { return $('#file-type-input').val() == '" . MeetingRecord::FILE_TYPE_MEETING . "'; }"],
			['file', 'file', 'skipOnEmpty' => false],
			['noticeUsers', 'each', 'rule' => ['integer']],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'meetingDate' => '会议日期',
			'file' => '会议记录文件',
			'fileType' => '文件类型',
			'topic' => '主题',
			'noticeUsers' => '上传后邮件通知如下人员',
		];
	}
	
	public function upload()
	{
		if ($this->validate()) {
			$filename = Yii::getAlias("@backend") . "/" . self::FILE_FOLDER . time() . '.' . $this->file->extension;
			$this->file->saveAs($filename);
			return $filename;
		} else {
			return null;
		}
	}
	
	/**
	 * 
	 * @param MeetingRecord $record
	 */
	public function sendMail($record)
	{
		if ($this->noticeUsers != null) {
			if ($record->file_type == MeetingRecord::FILE_TYPE_MEETING) {
				$title = $this->meetingDate . '会议记录';
			} else {
				$title = '您有新的内部文件';
			}
			foreach ($this->noticeUsers as $userId) {
				$user = User::findOne($userId);
				Yii::$app
					->mailer
					->compose(
						['html' => 'meetingRecord-html', 'text' => 'meetingRecord-text'],
						['username' => $user->username, 'record' => $record]
					)
					->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
					->setTo($user->email)
					->setSubject($title)
					->attach($record->file_path, ['fileName' => $record->org_name])
					->setCharset("UTF-8")
					->send();
			}
		}
	}

}