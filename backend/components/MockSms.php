<?php
namespace backend\components;

use Yii;
use yii\base\Component;

class MockSms extends Component
{
	public $apikey;
	public $adminUrl;
	public $templateId;

	public function sendRegSms($mobile, $password)
	{
		Yii::trace($mobile . "'s password is " . $password);
		Yii::$app->session->setFlash("password is: " . $password);
		return true;
	}

	public function sendSms($mobile, $text)
	{
		return true;
	}
}