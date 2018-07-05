<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dealer_shop".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $province
 * @property integer $city
 * @property integer $region
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class DealerShop extends \yii\db\ActiveRecord
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
        return 'dealer_shop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'province', 'city', 'region', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'user_id', 'province', 'city', 'region'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '开发业务员',
            'name' => '店名',
            'province' => '省份',
            'city' => '城市',
            'region' => '地区',
            'address' => '地址',
            'created_at' => '登记日期',
            'updated_at' => '更新日期',
            'created_by' => '登记人',
            'updated_by' => '更新人',
        ];
    }

    public function getProvinceRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'province']);
    }

    public function getCityRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'city']);
    }

    public function getRegionRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region']);
    }

    public function getOpener()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getAllShops()
    {
        $shops = DealerShop::find()->asArray()->all();
        return ArrayHelper::map($shops, 'id', 'name');
    }
}
