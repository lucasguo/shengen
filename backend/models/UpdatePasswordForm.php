<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class UpdatePasswordForm extends Model
{
	public $oldPassword;
	public $newPassword;
	public $newPasswordRepeat;
	
	public function rules()
	{
		return [
			[['oldPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
			[['oldPassword', 'newPassword', 'newPasswordRepeat'], 'string', 'max' => 30],
			[['newPasswordRepeat'], 'compare','compareAttribute'=>'newPassword'],
			['oldPassword', 'validateOldPassword'],
		];
		
	}
	
	public function attributeLabels()
	{
		return [
			'oldPassword' => '原密码',
			'newPassword' => '新密码',
			'newPasswordRepeat' => '确认密码',
		];
	}
	
	public function validateOldPassword($attribute, $params)
	{
		if(!Yii::$app->user->identity->validatePassword($this->oldPassword))
		{
			$this->addError($attribute, '原密码错误');
		}
	}

}