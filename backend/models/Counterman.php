<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "counterman".
 *
 * @property integer $id
 * @property string $counterman_name
 * @property integer $city_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Counterman extends \yii\db\ActiveRecord
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
        return 'counterman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['counterman_name', 'city_id'], 'required'],
            [['city_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['counterman_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'counterman_name' => '姓名',
            'city_id' => '所在城市',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(Region::class, ['id' => 'city_id']);
    }

    public static function getAllCounterman()
    {
        $result = static::find()->asArray()->all();
        return ArrayHelper::map($result, 'id', 'counterman_name');
    }
}
