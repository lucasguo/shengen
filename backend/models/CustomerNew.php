<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "customer_new".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $customer_mobile
 * @property string $customer_company
 * @property string $customer_job
 * @property string $comment
 * @property integer $customer_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CustomerNew extends \yii\db\ActiveRecord
{
    const TYPE_HOSPITAL = 0;
    const TYPE_COMPANY = 1;
    const TYPE_PATIENT = 2;

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
        return 'customer_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_name', 'customer_mobile'], 'required'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['customer_name'], 'string', 'max' => 10],
            [['customer_mobile'], 'string', 'max' => 15],
            [['customer_company'], 'string', 'max' => 50],
            [['customer_job'], 'string', 'max' => 20],
            [['customer_mobile'], 'unique'],
            [['customer_type'], 'in', 'range' => [self::TYPE_HOSPITAL, self::TYPE_COMPANY, self::TYPE_PATIENT]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => '姓名',
            'customer_mobile' => '手机',
            'customer_company' => '公司',
            'customer_job' => '职位',
            'comment' => '备注',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_COMPANY => '经销商客户',
            self::TYPE_HOSPITAL => '医院客户',
            self::TYPE_PATIENT => '患者'
        ];
    }

    /**
     * @return array
     */
    public static function getTypeCompanyList()
    {
        return [
            self::TYPE_COMPANY => '公司',
            self::TYPE_HOSPITAL => '医院',
            self::TYPE_PATIENT => '地址'
        ];
    }

    /**
     * @return string
     */
    public function getTypeLabel()
    {
        return self::getTypeList()[$this->customer_type];
    }

    public static function getTypeLabelFromCode($code)
    {
        return self::getTypeList()[$code];
    }

    public static function getTypeCompanyLabelFromCode($code)
    {
        return self::getTypeCompanyList()[$code];
    }
}
