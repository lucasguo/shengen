<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $master_id
 * @property integer $machine_id
 * @property string $expect_install_date
 * @property string $install_date
 * @property integer $status
 * @property string $sold_price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property OrderMaster $master
 */
class OrderDetail extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 0;
	const STATUS_INSTALLED = 1;
	
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
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['status', 'default', 'value' => self::STATUS_ACTIVE],
        	['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INSTALLED]],
        	[['expect_install_date', 'install_date'], 'date', 'format' => 'php:Y-m-d'],
            [['master_id', 'machine_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['sold_price'], 'number'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => '主订单号',
            'machine_id' => '仪器号',
        	'status' => '状态',
            'sold_price' => '销售价格',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(OrderMaster::className(), ['id' => 'master_id'])->inverseOf('orderDetails');
    }
    
    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
    		self::STATUS_ACTIVE => '正常',
    		self::STATUS_INSTALLED => '已安装',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->status];
    }
}
