<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "amend_record".
 *
 * @property integer $id
 * @property integer $machine_id
 * @property integer $before_part_id
 * @property integer $after_part_id
 * @property string $comment
 * @property integer $ament_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class AmendRecord extends \yii\db\ActiveRecord
{
    const TYPE_FIX = 0;
    const TYPE_REPLACE = 1;

    const PART_OTHER = -1;
    const PART_OTHER_NAME = '其他';

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
        return 'amend_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['machine_id', 'before_part_id', 'ament_type'], 'required'],
            [['machine_id', 'before_part_id', 'after_part_id', 'ament_type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_id' => 'Machine ID',
            'before_part_id' => '维修部件',
            'after_part_id' => 'After Part ID',
            'comment' => '维修备注',
            'ament_type' => '维修类型',
            'created_at' => '维修时间',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
    	return [
    	    self::TYPE_FIX => '维修',
            self::TYPE_REPLACE => '更换',
    	];
    }

    /**
     * @return string
     */
    public function getTypeLabel()
    {
    	return self::getTypeList()[$this->ament_type];
    }

    public function getOldPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'before_part_id'])->from(['old' => Part::tableName()]);
    }

    public function getNewPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'after_part_id'])->from(['new' => Part::tableName()]);
    }

    public function getMachine()
    {
        return $this->hasOne(MachineMaster::className(), ['id' => 'machine_id']);
    }
}
