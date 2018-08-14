<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hospital".
 *
 * @property integer $id
 * @property string $hospital_name
 * @property integer $hospital_province
 * @property integer $hospital_city
 * @property integer $hospital_district
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Hospital extends \yii\db\ActiveRecord
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
        return 'hospital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hospital_name', 'hospital_city'], 'required'],
            [['hospital_province', 'hospital_city', 'hospital_district', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['hospital_name'], 'string', 'max' => 40],
            [['hospital_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hospital_name' => '医院名称',
            'hospital_province' => '医院所在省份',
            'hospital_city' => '医院所在城市',
            'hospital_district' => '医院所在地区',
            'comment' => '备注',
            'created_at' => '创建于',
            'updated_at' => '更新于',
            'created_by' => '创建人',
            'updated_by' => '更新人',
        ];
    }

    public function getCityRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'hospital_city']);
    }

    public static function getHospitalList()
    {
        $result = static::find()->asArray()->all();
        return ArrayHelper::map($result, 'id', 'hospital_name');
    }

    public static function getHospitalNameById($id)
    {
        $result = static::findOne($id);
        if($result != null) {
            return $result->hospital_name;
        }
        return null;
    }
}
