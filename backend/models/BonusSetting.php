<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "bonus_setting".
 *
 * @property integer $id
 * @property string $single_price
 * @property string $single_cost
 * @property string $once_return
 * @property string $sale_bonus
 * @property string $manage_bonus
 * @property string $yearly_bonus
 * @property integer $level_limit
 * @property integer $return_day_limit
 * @property integer $product_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class BonusSetting extends \yii\db\ActiveRecord
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
        return 'bonus_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['single_price', 'once_return', 'sale_bonus', 'manage_bonus'], 'required'],
            [['single_price', 'once_return', 'sale_bonus', 'manage_bonus'], 'number'],
            [[ 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_id'], 'integer'],
//        	['level_limit', 'integer', 'max' => 15, 'message' => '当前系统最大支持15级'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'single_price' => '单台售价(元)',
        	'single_cost' => '单台成本(元)',
            'once_return' => '销售立返(元)',
            'sale_bonus' => '销售奖单台提成比例(%)',
            'manage_bonus' => '管理奖对下级提成比例(%)',
            'level_limit' => '最多级数',
            'return_day_limit' => '最大允许退货天数',
        	'yearly_bonus' => '年终奖比例(%)',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
    
}
