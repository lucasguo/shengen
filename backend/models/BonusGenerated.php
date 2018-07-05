<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bonus_generated".
 *
 * @property integer $id
 * @property integer $sold_critical
 * @property integer $bonus_type
 * @property integer $product_id
 * @property string $bonus_amount
 */
class BonusGenerated extends \yii\db\ActiveRecord
{
	const TYPE_ONCE_RETURN = 1;
	const TYPE_SALE_BONUS = 2;
	const TYPE_MANAGE_BONUS = 3;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_generated';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sold_critical', 'bonus_type', 'bonus_amount'], 'required'],
            [['sold_critical', 'bonus_type', 'product_id'], 'integer'],
            [['bonus_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sold_critical' => 'Sold Critical',
            'bonus_type' => 'Bonus Type',
            'bonus_amount' => 'Bonus Amount',
        ];
    }
}
