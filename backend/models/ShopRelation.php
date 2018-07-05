<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop_relation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $shop_id
 */
class ShopRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id'], 'required'],
            [['user_id'], 'integer'],
            [['shop_id'], 'string', 'max' => 255],
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
            'shop_id' => 'Shop ID',
        ];
    }
}
