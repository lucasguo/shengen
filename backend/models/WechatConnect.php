<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wechat_connect".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $openid
 * @property integer $created_at
 * @property integer $updated_at
 */
class WechatConnect extends \yii\db\ActiveRecord
{
	/**
	 * (non-PHPdoc)
	 * @see \yii\base\Component::behaviors()
	 */
	public function behaviors(){
		return [
			TimestampBehavior::className(),
		];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_connect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'openid'], 'required'],
            [['userid', 'created_at', 'updated_at'], 'integer'],
            [['openid'], 'string', 'max' => 40],
            [['openid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'openid' => 'Openid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
