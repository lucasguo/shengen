<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $customer_mobile
 * @property string $customer_address
 * @property string $customer_corp
 * @property string $customer_sn
 * @property integer $customer_status
 * @property integer $belongto
 * @property integer $customer_type
 * @property integer $auto_convert
 * @property string $bankaccount
 * @property string $bankname
 * @property string $beneficiary
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Customer extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 0;
	const STATUS_BOUGHT = 1;
	
	const TYPE_SINGLE = 0;
	const TYPE_COMPANY = 1;
	
	/**
	 * (non-PHPdoc)
	 * @see \yii\base\Component::behaviors()
	 */
	public function behaviors(){
		return [
			TimestampBehavior::className(),
			BlameableBehavior::className(),
		];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }
    
    public function scenarios()
    {
    	return [
    		'new' => ['customer_name', 'customer_mobile', 'customer_address', 'belongto', 'customer_status', 'customer_corp', 'customer_type'],
    		'update' => ['customer_name', 'customer_mobile', 'customer_address', 'belongto', 'customer_status', 'customer_corp', 'customer_type'],
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['customer_status', 'default', 'value' => self::STATUS_ACTIVE, 'on' => ['new', 'update']],
        	['customer_status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BOUGHT], 'on' => ['new', 'update']],
            [['customer_name', 'customer_mobile', 'customer_address'], 'required', 'on' => ['new', 'update']],
        	['belongto', 'required', 'on' => 'update'],
            [['customer_address', 'customer_corp', 'customer_sn'], 'string', 'on' => ['new', 'update']],
            [['belongto', 'customer_status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer', 'on' => ['new', 'update']],
        	['belongto', 'default', 'value' => Yii::$app->user->id, 'on' => ['new', 'update']],
            [['customer_name'], 'string', 'max' => 255, 'on' => ['new', 'update']],
            [['customer_mobile'], 'string', 'max' => 25, 'on' => ['new', 'update']],
            [['customer_mobile'], 'unique', 'on' => ['new', 'update']],
        	[['bankaccount'], 'string', 'max' => 30, 'on' => ['new']],
        	[['bankname'], 'string', 'max' => 80, 'on' => ['new']],
        	[['beneficiary'], 'string', 'max' => 10, 'on' => ['new']],
        	[['auto_convert'], 'integer', 'on' => ['new']],
        	[['customer_type'], 'integer', 'on' => ['new', 'update']],
        	['customer_type', 'default', 'value' => self::TYPE_SINGLE, 'on' => ['new', 'update']],
        	['customer_corp', 'required', 'when' => function ($model) { return $model->customer_type == self::TYPE_COMPANY; }, 'whenClient' => "function (attribute, value) { return $('#type').val() == '1'; }"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => '客户姓名',
        	'customer_sn' => '客户编号',
        	'customer_corp' => '客户公司',
        	'customer_type' => '客户类型',
            'customer_mobile' => '客户联系电话',
            'customer_address' => '客户地址',
            'belongto' => '归属',
        	'customer_status' => '状态',
        	'bankaccount' => '收取提成收益的银行账号',
        	'bankname' => '收取提成收益的银行名称',
        	'beneficiary' => '收取提成收益的受益人',
        	'auto_convert' => '是否发展为代理商（勾选后他将可以登录系统）',
            'created_at' => '创建日期',
            'updated_at' => '更新日期',
        ];
    }
    
    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
    		self::STATUS_ACTIVE => '正常',
    		self::STATUS_BOUGHT => '已购买仪器',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->customer_status];
    }
    
    /**
     * @return array
     */
    public static function getTypeList()
    {
    	return [
    		self::TYPE_COMPANY => '经销商',
    		self::TYPE_SINGLE => '终端客户',
    		
    	];
    }
    
    /**
     * @return string
     */
    public function getTypeLabel()
    {
    	return self::getTypeList()[$this->customer_type];
    }
    
    /**
     * @return string
     */
    public static function getStatusLabelFromCode($code)
    {
    	return self::getStatusList()[$code];
    }
    
    public function getBelongtoUsername()
    {
    	if(!empty($this->belongto)) {
    		return User::findOne($this->belongto)->username;
    	}
    	return "";
    }
    
    public function generateSn()
    {
    	$this->customer_sn = 'KH' . date('Ymdhis');
    	return true;
    }
}
