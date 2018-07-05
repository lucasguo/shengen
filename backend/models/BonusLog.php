<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bonus_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property integer $sold_critical
 * @property integer $bonus_type
 * @property integer $product_id
 * @property string $bonus_amount
 * @property string $bonus_date
 */
class BonusLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id', 'sold_critical', 'bonus_type', 'bonus_amount', 'bonus_date'], 'required'],
            [['user_id', 'order_id', 'sold_critical', 'bonus_type', 'product_id'], 'integer'],
            [['bonus_amount'], 'number'],
            [['bonus_date'], 'safe'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'sold_critical' => 'Sold Critical',
            'bonus_type' => 'Bonus Type',
            'bonus_amount' => 'Bonus Amount',
            'bonus_date' => 'Bonus Date',
        ];
    }
}
