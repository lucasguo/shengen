<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class UpdateEmailForm extends Model
{
	public $email;
	public $username;
	public $mobile;
	
	public function rules()
	{
		return [
			['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
			[['username', 'mobile'], 'safe'],
		];
		
	}
	
	public function attributeLabels()
	{
		return [
			'username' => '姓名',
			'mobile' => '手机号码',
		];
	}

}