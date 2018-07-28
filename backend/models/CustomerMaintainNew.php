<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "customer_maintain_new".
 *
 * @property integer $id
 * @property string $content
 * @property integer $customer_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class CustomerMaintainNew extends \yii\db\ActiveRecord
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
        return 'customer_maintain_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'customer_id'], 'required'],
            [['content'], 'string'],
            [['customer_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '提醒内容',
            'customer_id' => 'Customer ID',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }
}
