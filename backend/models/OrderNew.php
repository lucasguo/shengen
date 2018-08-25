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
 * @property integer $order_status
 * @property integer $org_order_id
 * @property string $sell_amount
 * @property integer $counterman_id
 * @property integer $dealer_id
 * @property integer $hospital_id
 * @property integer $order_date
 * @property string $office
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

    public function getOrderDate()
    {
        if(!empty($this->order_date)) {
            return date("Y-m-d", $this->order_date);
        } else {
            return date("Y-m-d");
        }
    }

    public function setOrderDate($time)
    {
        $this->order_date = strtotime($time);
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
            'default' => ['model_id', 'sell_count', 'sell_amount', 'counterman_id', 'dealer_id', 'hospital_id', 'order_date', 'office', 'orderDate'],
            'deal' => ['model_id', 'sell_count', 'sell_amount', 'counterman_id', 'dealer_id', 'hospital_id', 'order_date', 'office', 'orderDate'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'hospital_id', 'dealer_id'], 'required', 'on' => ['default', 'deal']],
            [['sell_amount'], 'required', 'on' => ['deal']],
            [['model_id', 'sell_count', 'order_status', 'org_order_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'counterman_id', 'dealer_id', 'hospital_id', 'order_date'], 'integer', 'on' => ['default', 'deal']],
            [['sell_amount'], 'number', 'on' => ['default', 'deal']],
            [['office', 'orderDate'], 'string', 'on' => ['default', 'deal']],
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
            'order_status' => '状态',
            'org_order_id' => '原始订单',
            'sell_amount' => '成交总价',
            'created_at' => '创建于',
            'updated_at' => '更新于',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'counterman_id' => '业务员',
            'dealer_id' => '报单人',
            'hospital_id' => '报单医院',
            'order_date' => '报单日期',
            'office' => '报单科室',
            'orderDate' => '报单日期',
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

    public function getHospital()
    {
        return $this->hasOne(Hospital::class, ['id' => 'hospital_id']);
    }

    public function getCounterman()
    {
        return $this->hasOne(Counterman::class, ['id' => 'counterman_id']);
    }

    public function getDealer()
    {
        return $this->hasOne(CustomerNew::class, ['id' => 'dealer_id']);
    }

    /**
     * @param $orgOrder OrderNew
     */
    public function copyFromOrg($orgOrder) {
        $this->model_id = $orgOrder->model_id;
        $this->sell_count = $orgOrder->sell_count;
        $this->org_order_id = $orgOrder->id;
        $this->dealer_id = $orgOrder->dealer_id;
        $this->hospital_id = $orgOrder->hospital_id;
        $this->counterman_id = $orgOrder->counterman_id;
        $this->order_date = $orgOrder->order_date;
        $this->office = $orgOrder->office;
    }
}
