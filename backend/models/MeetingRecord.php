<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "meeting_record".
 *
 * @property integer $id
 * @property string $meeting_date
 * @property string $file_path
 * @property string $org_name
 * @property string $topic
 * @property integer $file_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class MeetingRecord extends \yii\db\ActiveRecord
{

	const FILE_TYPE_MEETING = 0;
	const FILE_TYPE_OTHER = 1;
	const FILE_MONTHLY_REPORT = 2;
	const FILE_MONTHLY_SCHEDULE = 3;
	
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
        return 'meeting_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_path', 'org_name'], 'required'],
            [['meeting_date'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'file_type'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
        	[['topic', 'org_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meeting_date' => 'Meeting Date',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
    

    /**
     * @return array
     */
    public static function getFileTypeList()
    {
    	return [
    		self::FILE_TYPE_MEETING => '会议记录',
    		self::FILE_TYPE_OTHER => '其他',
    		self::FILE_MONTHLY_REPORT => '月报表',
    		self::FILE_MONTHLY_SCHEDULE => '月计划',
    	];
    }
    
    /**
     * @return string
     */
//     public function getFileTypeLabel()
//     {
//     	return self::getFileTypeList()[$this->file_type];
//     }
    
    /**
     * @return string
     */
    public static function getFileTypeLabel($type)
    {
    	return static::getFileTypeList()[$type];
    }
}
