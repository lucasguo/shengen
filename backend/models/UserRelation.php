<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_relation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $up_id
 * @property integer $product_id
 */
class UserRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'up_id', 'product_id'], 'integer'],
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
            'up_id' => 'Up ID',
            'product_id' => 'Product ID',
        ];
    }
}
