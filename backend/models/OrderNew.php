<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "order_new".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $sell_count
 * @property integer $customer_id
 * @property integer $order_status
 * @property integer $org_order_id
 * @property string $sell_amount
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class OrderNew extends \yii\db\ActiveRecord
{
    const STATUS_INIT = 0;
    const STATUS_DEAL = 1;
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
        return 'order_new';
    }

    public function scenarios()
    {
        return [
            'default' => ['model_id', 'customer_id', 'sell_count', 'sell_amount'],
            'deal' => ['model_id', 'customer_id', 'sell_count', 'sell_amount'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'customer_id'], 'required', 'on' => ['default', 'deal']],
            [['sell_amount'], 'required', 'on' => ['deal']],
            [['model_id', 'sell_count', 'customer_id', 'order_status', 'org_order_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer', 'on' => ['default', 'deal']],
            [['sell_amount'], 'number', 'on' => ['default', 'deal']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => '产品型号',
            'sell_count' => '台数',
            'customer_id' => '客户',
            'order_status' => '状态',
            'org_order_id' => '原始订单',
            'sell_amount' => '成交总价',
            'created_at' => '创建于',
            'updated_at' => '更新于',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
    	    static::STATUS_INIT => '备案',
            static::STATUS_DEAL => '成交',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->order_status];
    }

    public function getCustomer() {
        return $this->hasOne(CustomerNew::class, ['id' => 'customer_id']);
    }

    public function copyFromOrg($orgOrder) {
        $this->customer_id = $orgOrder->customer_id;
        $this->model_id = $orgOrder->model_id;
        $this->customer_id = $orgOrder->customer_id;
        $this->sell_count = $orgOrder->sell_count;
        $this->org_order_id = $orgOrder->id;
    }
}
