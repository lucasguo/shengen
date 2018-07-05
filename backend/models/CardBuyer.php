<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "card_buyer".
 *
 * @property integer $id
 * @property string $buyername
 * @property string $sex
 * @property string $address
 * @property integer $shop_id
 * @property string $mobile
 * @property integer $symptom
 * @property string $other_symptom
 * @property integer $intro_type
 * @property string $intro_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CardBuyer extends \yii\db\ActiveRecord
{
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    const INTRO_NONE = 0;
    const INTRO_BY_PEOPLE = 1;
    const INTRO_BY_HOSPITAL = 2;

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
        return 'card_buyer';
    }

    public static function getSexList()
    {
        return [
            self::SEX_MALE => '男',
            self::SEX_FEMALE => '女',
        ];
    }

    public function getSexLabel()
    {
        return static::getSexList()[$this->sex];
    }

    public static function getIntroList()
    {
        return [
            self::INTRO_NONE => '无',
            self::INTRO_BY_PEOPLE => '顾客引荐',
            self::INTRO_BY_HOSPITAL => '医院引荐',
        ];
    }

    public function getIntroLabel()
    {
        return static::getIntroList()[$this->intro_type];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $otherId = Symptom::OTHER_SYMPTON_ID;
        $noneType = self::INTRO_NONE;
        return [
            [['buyername', 'sex', 'shop_id', 'mobile', 'symptom', 'intro_type'], 'required'],
            [['shop_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'symptom', 'intro_type'], 'integer'],
            [['buyername', 'address', 'mobile'], 'string', 'max' => 255],
            [['other_symptom'], 'string', 'max' => 30],
            [['intro_name'], 'string', 'max' => 50],
            [['other_symptom'], 'required', 'when' => function ($model) {
                return $model->symptom == 'other';
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=radio][name=\"CollectCardBuyerForm[symptom]\"]:checked').val() == $otherId || $('input[type=radio][name=\"CardBuyer[symptom]\"]:checked').val() == $otherId;
          }"],
            [['intro_name'], 'required', 'when' => function ($model) {
                return $model->intro_type != self::INTRO_NONE;
            }, 'whenClient' => "function (attribute, value) {
                return $('#intro_type').val() != $noneType;
          }"],
            [['sex'], 'string', 'max' => 1],
            [['shop_id', 'mobile'], 'unique', 'targetAttribute' => ['shop_id', 'mobile'], 'message' => '该手机号已存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyername' => '顾客姓名',
            'sex' => '顾客性别',
            'address' => '地址',
            'shop_id' => '所在门店',
            'mobile' => '联系方式',
//            'urgentperson' => '紧急联系人姓名',
//            'urgentmobile' => '紧急联系人联系方式',
            'intro_type' => '引荐单位',
            'intro_name' => '引荐人',
            'symptom' => '症状',
            'created_at' => '录入日期',
            'other_symptom' => '症状描述',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getSymptomDetail()
    {
        return $this->hasOne(Symptom::className(), ['id' => 'symptom']);
    }

    public function getShop()
    {
        return $this->hasOne(DealerShop::className(), ['id' => 'shop_id']);
    }

    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCards()
    {
        return $this->hasMany(Card::className(), ['buyer_id' => 'id']);
    }
}
