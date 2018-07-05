<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_bonus".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $return_bonus
 * @property string $sale_bonus
 * @property string $manage_bonus
 * @property integer $user_level
 * @property integer $product_id
 */
class UserBonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'return_bonus', 'sale_bonus', 'manage_bonus'], 'required'],
            [['user_id', 'user_level'], 'integer'],
            [['return_bonus', 'sale_bonus', 'manage_bonus'], 'number'],
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
            'return_bonus' => 'Return Bonus',
            'sale_bonus' => 'Sale Bonus',
            'manage_bonus' => 'Manage Bonus',
        ];
    }
}
