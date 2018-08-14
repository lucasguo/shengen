<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "customer_new_extend".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $gender
 * @property integer $birth_year
 * @property string $diagnosis
 * @property string $disease_course
 * @property string $treat_plan
 * @property integer $doctor_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CustomerNewExtend extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
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
        return 'customer_new_extend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'gender'], 'required'],
            [['customer_id', 'gender', 'birth_year', 'doctor_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['diagnosis', 'disease_course', 'treat_plan'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'gender' => '性别',
            'birth_year' => '年龄',
            'diagnosis' => '诊断',
            'disease_course' => '病程',
            'treat_plan' => '治疗方案',
            'doctor_id' => '介绍专家',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }

    /**
     * @param $extend CustomerNewExtend
     */
    public function copyFromScreen($extend) {
        $this->birth_year = $extend->birth_year;
        $this->diagnosis = $extend->diagnosis;
        $this->disease_course = $extend->disease_course;
        $this->doctor_id = $extend->doctor_id;
        $this->gender = $extend->gender;
        $this->treat_plan = $extend->treat_plan;
    }

    public static function getGenderList() {
        return [
            CustomerNewExtend::GENDER_MALE => '男',
            CustomerNewExtend::GENDER_FEMALE => '女'
        ];
    }
}
