<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_model".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $model_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class ProductModel extends \yii\db\ActiveRecord
{
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
        return 'product_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'model_name'], 'required'],
            [['product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['model_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => '产品',
            'model_name' => '型号',
            'created_at' => '创建于',
            'updated_at' => '更新于',
            'product_list' => '产品列表',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getProduct() {
        return $this->hasOne(MachineProduct::class, ['id' => 'product_id']);
    }

    public static function getFullProductModelName($id) {
        $result = static::findBySql('
        SELECT CONCAT(p.product_name, \' - \', m.model_name) as model_name
        FROM product_model m 
        LEFT JOIN machine_product p ON p.id = m.product_id
        WHERE p.id = :id
        ', [':id' => $id])->one();
        return $result->model_name;
    }

    public static function getAllProductModels() {
        $result = static::findBySql('
        SELECT m.id, CONCAT(p.product_name, \' - \', m.model_name) as model_name
        FROM product_model m 
        LEFT JOIN machine_product p ON p.id = m.product_id
        WHERE p.product_status = :status
        ', [':status' => MachineProduct::STATUS_ACTIVE])->all();
        return ArrayHelper::map($result, 'id', 'model_name');
    }
}
