<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "finance".
 *
 * @property integer $id
 * @property integer $type
 * @property string $amount
 * @property integer $userid
 * @property string $content
 * @property string $occur_date
 * @property integer $status
 * @property string $relate_table
 * @property integer $relate_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Finance extends \yii\db\ActiveRecord
{
	const STATUS_COLLECTED = 0;
	const STATUS_APPROVED = 1;
	
	const TYPE_ORDER = 1;
	const TYPE_OTHER_INCOMING = 2;
	const TYPE_BUY_PROD = -1;
	const TYPE_OFFICE = -2;
	const TYPE_HOSPITALITY = -3;
	const TYPE_SALARY = -4;
	const TYPE_OTHER_OUTGOING = -5;
	const TYPE_RENT = -6;
	
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
        return 'finance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['status', 'default', 'value' => self::STATUS_COLLECTED],
        	['status', 'in', 'range' => [self::STATUS_COLLECTED, self::STATUS_APPROVED]],
            [['type', 'amount', 'content', 'status', 'occur_date'], 'required'],
            [['type', 'userid', 'status', 'relate_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['content'], 'string'],
            [['relate_table'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'amount' => '金额',
            'userid' => '相关人员',
            'content' => '内容',
            'status' => '状态',
        	'occur_date' => '发生日期',
            'relate_table' => 'Relate Table',
            'relate_id' => 'Relate ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => '填写日期',
            'updated_at' => 'Updated At',
        ];
    }
    
    public static function getStautsList()
    {
    	return [
    		self::STATUS_COLLECTED => '录入',
    		self::STATUS_APPROVED => '批准',
    	];
    }
    
    public function getStatusLabel()
    {
    	return static::getStautsList()[$this->status];
    }
    
    public static function getTypeList()
    {
    	return [
    		self::TYPE_ORDER => '订单收入',
    		self::TYPE_OTHER_INCOMING => '其他收入',
    		self::TYPE_BUY_PROD => '购买仪器',
    		self::TYPE_OFFICE => '日常开支',
    		self::TYPE_HOSPITALITY => '招待费用',
    		self::TYPE_SALARY => '工资福利',
    		self::TYPE_OTHER_OUTGOING => '其他支出',
    		self::TYPE_RENT=>'办公室租金',
    	];
    }
    
    public function getTypeLabel()
    {
    	return static::getTypeList()[$this->type];
    }
    
    public static function getIncomingTypeList()
    {
    	return [
    		self::TYPE_ORDER => '订单收入',
    		self::TYPE_OTHER_INCOMING => '其他收入',
    	];
    }
    
    public static function getOutgoingTypeList()
    {
    	return [
    		self::TYPE_BUY_PROD => '购买仪器',
    		self::TYPE_OFFICE => '日常开支',
    		self::TYPE_HOSPITALITY => '招待费用',
    		self::TYPE_SALARY => '工资福利',
    		self::TYPE_OTHER_OUTGOING => '其他支出',
    		self::TYPE_RENT=>'办公室租金',
    	];
    }
}
