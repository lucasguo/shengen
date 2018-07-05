<?php
namespace backend\models;

use yii\base\Model;

class MyCustomerForm extends Model
{
	
	public $customer_email;
	public $customer_name;
	public $customer_mobile;
	public $bankaccount;
	public $bankname;
	public $beneficiary;
	public $auto_convert;
	
	public function rules() {
		return [
			[["customer_name", "customer_mobile", 'bankaccount', 'bankname', 'beneficiary'], 'required'],
			["customer_email", "email"],
			['customer_mobile', 'match', 'pattern' => '/^1[3|4|5|8][0-9]\d{4,8}$/', 'message' => '无效的手机号码'],
			['customer_mobile', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'mobile', 'message' => '该手机号码已被注册'],
			['customer_mobile', 'unique', 'targetClass' => '\backend\models\Customer', 'message' => '该手机号码已被注册'],
			['customer_email', 'filter', 'filter' => 'trim'],
			['customer_email', 'string', 'max' => 255],
			['customer_email', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'email', 'message' => '该Email已被注册'],
		];
	}
	
	public function attributeLabels() {
		return [
			'customer_email' => '顾客邮箱',
			'customer_name' => '客户姓名',
			'customer_mobile' => '客户联系电话',
			'bankaccount' => '提成收入银行账号',
			'bankname' => '银行名称',
			'beneficiary' => '收款人姓名',
			'auto_convert' => '顾客付款后将其加入系统',
		];
	}
}