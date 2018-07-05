<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "machine".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $machine_sn
 * @property string $machine_cost
 * @property integer $machine_status
 * @property string $in_datetime
 * @property string $out_datetime
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class MachineMaster extends \yii\db\ActiveRecord
{
	const STATUS_WAREHOUSED = 0;
	const STATUS_SOLD = 1;
	const STATUS_BROKEN = 2;
	
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
        return 'machine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['machine_status', 'default', 'value' => self::STATUS_WAREHOUSED],
        	['machine_status', 'in', 'range' => [self::STATUS_WAREHOUSED, self::STATUS_BROKEN, self::STATUS_SOLD]],
            [['product_id', 'machine_sn', 'machine_cost'], 'required'],
            [['product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['machine_cost'], 'number'],
            [['machine_sn', 'in_datetime', 'out_datetime'], 'string', 'max' => 255],
            [['machine_sn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => '产品类型',
            'machine_sn' => '仪器编号',
            'machine_cost' => '成本价',
            'in_datetime' => '入库日期',
            'out_datetime' => '出库日期',
        	'machine_status' => '状态',
            'created_at' => '创建日期',
            'updated_at' => '更新日期',
        ];
    }
    
    /**
     * @return array
     */
    public static function getStatusList()
    {
    	return [
    		self::STATUS_BROKEN => '损坏',
    		self::STATUS_SOLD => '已售',
    		self::STATUS_WAREHOUSED => '在库',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->machine_status];
    }
    
    public static function getStatusLabelFromCode($status)
    {
    	return self::getStatusList()[$status];
    }
    
    public function prepareMachineForm()
    {
    	$model = new MachineForm();
    	$model->fromMachineMaster($this);
    	$types = ProductPartType::getProductPartTypesById($this->product_id);
    	$model->updateFields(ArrayHelper::getColumn($types, 'part_name'));
    	for($i = 0; $i < count($types); $i ++) {
    		$fieldname = 'field' . ($i + 1);
    		$part = MachinePart::findOne(['machine_id' => $this->id, 'part_type_id' => $types[$i]->id]);
    		if ($part != null) {
                $partId = MachinePart::findOne(['machine_id' => $this->id, 'part_type_id' => $types[$i]->id])->part_id;
                $model->$fieldname = Part::findOne($partId)->part_sn;
            }
    	}
    	return $model;
    }
    
    
}
