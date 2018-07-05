<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "part".
 *
 * @property integer $id
 * @property integer $part_type
 * @property string $part_sn
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Part extends \yii\db\ActiveRecord
{
	const STATUS_NORMAL = 0;
	const STATUS_BROKEN = 1;
	
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
        return 'part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['status', 'default', 'value' => self::STATUS_NORMAL],
        	['status', 'in', 'range' => [self::STATUS_NORMAL, self::STATUS_BROKEN]],
            [['part_type'], 'required'],
            [['part_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['part_sn'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_type' => '配件类型',
            'part_sn' => '配件序列号',
            'status' => '状态',
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
    		self::STATUS_NORMAL => '正常',
    	];
    }
    
    /**
     * @return string
     */
    public function getStatusLabel()
    {
    	return self::getStatusList()[$this->status];
    }

    public function getPartType() {
        return $this->hasOne(PartType::className(), ['id' => 'part_type']);
    }
}
