<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "order_master".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $sold_count
 * @property string $sold_amount
 * @property integer $sold_datetime
 * @property integer $need_invoice
 * @property integer $order_status
 * @property string $order_sn
 * @property integer $warranty_in_month
 * @property integer $allow_return
 * @property string $sold_date
 * @property string $confirm_date
 * @property string $out_date
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property OrderDetail[] $orderDetails
 */
class OrderMaster extends \yii\db\ActiveRecord
{
	const STATUS_COLLECTED = 0;
	const STATUS_PREPARE_OUT = 1;
	const STATUS_INSTALLED = 2;
	const STATUS_IN_WARRANTY = 3;
	const STATUS_OUT_WARRANTY = 4;
	const STATUS_CONFIRMED = 5;
	
	
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
        return 'order_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['order_status', 'default', 'value' => self::STATUS_PREPARE_OUT],
        	['order_status', 'in', 'range' => [self::STATUS_COLLECTED, self::STATUS_IN_WARRANTY, self::STATUS_INSTALLED, self::STATUS_OUT_WARRANTY, self::STATUS_PREPARE_OUT, self::STATUS_CONFIRMED]],
            [['customer_id', 'sold_count', 'sold_amount', 'warranty_in_month'], 'required'],
            [['customer_id', 'sold_count', 'sold_datetime', 'need_invoice', 'created_at', 'updated_at', 'warranty_in_month', 'created_by', 'updated_by', 'allow_return', 'product_id'], 'integer'],
            [['sold_amount'], 'number'],
        	[['sold_date', 'confirm_date', 'out_date'], 'string'],
        	['allow_return', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => '购买客户',
            'sold_count' => '销售仪器数量',
            'sold_amount' => '销售总价',
            'sold_datetime' => '销售日期',
            'need_invoice' => '是否需要发票',
        	'order_status' => '状态',
        	'order_sn' => '订单编号',
        	'warranty_in_month' => '保修期限(月数)',
            'created_at' => '创建日期',
            'updated_at' => '更新日期',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['master_id' => 'id'])->inverseOf('master');
    }
    
    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
    		self::STATUS_COLLECTED => '已录入',
    		self::STATUS_IN_WARRANTY => '在保',
    		self::STATUS_INSTALLED => '已安装',
    		self::STATUS_OUT_WARRANTY => '过保',
    		self::STATUS_PREPARE_OUT => '出库',
    		self::STATUS_CONFIRMED => '已入账',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->order_status];
    }
    
    /**
     * @return string
     */
    public static function getStatusLabelByStatus($status)
    {
    	return self::getStatusList()[$status];
    }
    
    public function generateSn()
    {
    	$this->order_sn = 'DD' . date('Ymdhis');
    	return true;
    }
}
