<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "card_usage".
 *
 * @property integer $id
 * @property integer $card_id
 * @property integer $buyer_id
 * @property string $record
 * @property string $helpername
 * @property integer $use_datetime
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CardUsage extends \yii\db\ActiveRecord
{
    public $_useDate;

    public function getUseDate()
    {
        return date('Y-m-d', $this->use_datetime);
    }

    public function setUseDate($date) {
        $this->use_datetime = strtotime($date);
    }
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
        return 'card_usage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buyer_id', 'card_id', 'record', 'helpername', 'useDate'], 'required'],
            [['card_id', 'buyer_id', 'use_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['record', 'useDate'], 'string', 'max' => 255],
            [['helpername'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => '使用理疗卡',
            'record' => '治疗记录',
            'helpername' => '理疗师',
            'use_datetime' => '理疗时间',
            'useDate' => '理疗日期',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->status];
    }
    
    public function getCard()
    {
    	return $this->hasOne(Card::className(), ['id' => 'card_id']);
    }
}
