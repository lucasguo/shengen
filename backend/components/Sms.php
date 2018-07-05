<?php
namespace backend\components;

use Yii;
use yii\base\Component;

class Sms extends Component
{
	public $apikey;
	public $adminUrl;
	public $templateId;
	
	/**
	 * send a info sms to new registered user that container init password.
	 * @param string $mobile target mobile number
	 * @param string $password init password
	 * @return boolean whether sending is successful
	 */
	public function sendRegSms($mobile, $password)
	{
		$ch = $this->getCurl();
		$data=[
			'tpl_id'=>$this->templateId,
			'tpl_value'=>urlencode('#address#').'='.urlencode($this->adminUrl).'&'.urlencode('#password#').'='.urlencode($password),
			'apikey'=>$this->apikey,
			'mobile'=>$mobile,
		];
		curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/tpl_send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$json_data = curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($json_data,true);
		if($ret['code'] != 0) {
			Yii::error("error sending sms to " . $mobile . ". return value is: " . $json_data);
			return false;
		}
		return true;
	}
	
	/**
	 * Send a sms to a specific mobile number
	 * @param string $mobile target mobile number
	 * @param string $text sms content
	 * @return boolean whether sending is successful
	 */
	public function sendSms($mobile, $text)
	{
		$ch = $this->getCurl();
		$data=[
			'text'=>$text,
			'apikey'=>$this->apikey,
			'mobile'=>$mobile
		];
		curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$json_data = curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($json_data,true);
		if($ret['code'] != 0) {
			Yii::error("error sending sms to " . $mobile . ". return value is: " . $json_data);
			return false;
		}
		return true;
	}
	
	private function getCurl()
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		return $ch;
	}
}