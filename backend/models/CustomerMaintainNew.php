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
 * @property integer $alert_date
 * @property integer $alert_time
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
            [['content', 'customer_id', 'alert_date', 'alert_time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['customer_id', 'alert_date', 'alert_time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'customer_id' => 'Customer ID',
            'alert_date' => 'Alert Date',
            'alert_time' => 'Alert Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
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
