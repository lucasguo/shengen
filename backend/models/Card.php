<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card".
 *
 * @property integer $id
 * @property integer $card_type
 * @property integer $buyer_id
 * @property integer $shop_id
 * @property integer $left_times
 * @property integer $sold_datetime
 * @property string $card_no
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Card extends \yii\db\ActiveRecord
{
    const CARD_PREFIX = 'BILT';
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
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_type'], 'required'],
            [['card_type', 'buyer_id', 'shop_id', 'left_times', 'sold_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        	['card_no', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_type' => '卡种类',
            'buyer_id' => 'Buyer ID',
            'shop_id' => 'Shop ID',
            'left_times' => '剩余次数',
            'sold_datetime' => '售出日期',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function generateCardNo($shopId)
    {
        $date = date('Ym');
        $count = Card::find()->where(['shop_id' => $shopId])->count() + 1;
        return static::CARD_PREFIX . $date . sprintf('%05d', $count);
    }

    public static function getBuyerAvailableCards($buyerId)
    {
        $cards = Card::find()->where(['buyer_id' => $buyerId])->andWhere(['>', 'left_times', 0])->asArray()->all();
        return ArrayHelper::map($cards, 'id', 'card_no');
    }

    public function getCardType()
    {
        return $this->hasOne(CardType::className(), ['id' => 'card_type']);
    }
}
