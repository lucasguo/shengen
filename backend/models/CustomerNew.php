<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer_new".
 *
 * @property integer $id
 * @property string $customer_name
 * @property string $customer_mobile
 * @property string $customer_company
 * @property string $customer_job
 * @property string $comment
 * @property integer $city_id
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

    public $hospital_id;
    public $hospital_ids;
    /**
     * @var CustomerNewExtend
     */
    public $extend;

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
            [['created_at', 'updated_at', 'city_id', 'hospital_id'], 'integer'],
            [['customer_name'], 'string', 'max' => 10],
            [['customer_mobile'], 'string', 'max' => 15],
            [['customer_company'], 'string', 'max' => 50],
            [['customer_job'], 'string', 'max' => 20],
            [['customer_mobile'], 'unique'],
            ['hospital_ids', 'each', 'rule' => ['integer']],
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
            'city_id' => '所在地区',
            'hospital_id' => '关联医院',
            'hospital_ids' => '关联医院',
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
            self::TYPE_COMPANY => '经销客户',
            self::TYPE_HOSPITAL => '医院客户',
            self::TYPE_PATIENT => '肝病患者'
        ];
    }

    /**
     * @return array
     */
    public static function getTypeCompanyList()
    {
        return [
            self::TYPE_COMPANY => '公司',
            self::TYPE_HOSPITAL => '科室',
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

    public function getHospital()
    {
        $mapping = CustomerHospitalMapping::findOne(['customer_id' => $this->id]);
        if ($mapping != null) {
            return Hospital::getHospitalNameById($mapping->hospital_id);
        }
        return null;
    }

    public function getHospitals()
    {
        $mapping = CustomerHospitalMapping::findAll(['customer_id' => $this->id]);
        if ($mapping != null) {
            $names = [];
            foreach ($mapping as $hospital) {
                $names[] = Hospital::getHospitalNameById($hospital->hospital_id);
            }
            return join(", ", $names);
        }
        return null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        CustomerHospitalMapping::deleteAll(['customer_id' => $this->id]);
        if ($this->customer_type == CustomerNew::TYPE_COMPANY && $this->hospital_ids != null) {
            foreach ($this->hospital_ids as $index => $id) {
                $mapping = new CustomerHospitalMapping();
                $mapping->customer_id = $this->id;
                $mapping->hospital_id = $id;
                $mapping->save();
            }
        } else if($this->hospital_id != null) {
            $mapping = new CustomerHospitalMapping();
            $mapping->customer_id = $this->id;
            $mapping->hospital_id = $this->hospital_id;
            $mapping->save();
        }
        if ($this->customer_type == CustomerNew::TYPE_PATIENT) {
            $oldExtend = CustomerNewExtend::findOne(['customer_id' => $this->id]);
            if ($oldExtend == null) {
                $oldExtend = new CustomerNewExtend();
                $oldExtend->customer_id = $this->id;
            }
            $oldExtend->copyFromScreen($this->extend);
            $oldExtend->save();
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->customer_type == CustomerNew::TYPE_COMPANY) {
            $hospitalList = CustomerHospitalMapping::findAll(['customer_id' => $this->id]);
            if ($hospitalList != null) {
                $this->hospital_ids = ArrayHelper::getColumn($hospitalList, 'hospital_id');
            }
        } else {
            $hospital = CustomerHospitalMapping::findOne(['customer_id' => $this->id]);
            if ($hospital != null) {
                $this->hospital_id = $hospital->hospital_id;
            }
        }
    }

    public function afterDelete() {
        parent::afterDelete();
        CustomerHospitalMapping::deleteAll(['customer_id' => $this->id]);
        CustomerNewExtend::deleteAll(['customer_id' => $this->id]);
    }

    public static function getAllDoctors()
    {
        $result = static::find()->where(['customer_type'=> CustomerNew::TYPE_HOSPITAL])->asArray()->all();
        return ArrayHelper::map($result, 'id', 'customer_name');
    }

    public static function getAllCustomers()
    {
        $result = static::find()->asArray()->all();
        return ArrayHelper::map($result, 'id', 'customer_name');
    }
}
