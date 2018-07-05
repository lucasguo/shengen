<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "machine_product".
 *
 * @property integer $id
 * @property string $product_code
 * @property string $product_name
 * @property integer $product_status
 * @property integer $is_default
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class MachineProduct extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 0;
	const STATUS_PAUSED = 1;
	
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
        return 'machine_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['product_status', 'default', 'value' => self::STATUS_ACTIVE],
        	['product_status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_PAUSED]],
            [['product_code', 'product_name'], 'required'],
            [['product_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_default'], 'integer'],
            [['product_code', 'product_name'], 'string', 'max' => 255],
            [['product_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_code' => '产品代码',
            'product_name' => '产品名',
            'product_status' => '状态',
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
			self::STATUS_ACTIVE => '在售',
			self::STATUS_PAUSED => '停售',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->product_status];
    }
    
    public static function getAllProductList()
    {
    	$products = self::find()->all();
    	return ArrayHelper::map($products, 'id', 'product_name');
    }
    
    /**
     * 
     * @return \backend\models\MachineProduct|NULL
     */
    public static function getDefaultProduct()
    {
    	return self::findOne(['is_default' => 1]);
    }
    
}
