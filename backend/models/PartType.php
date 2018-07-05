<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "part_type".
 *
 * @property integer $id
 * @property string $part_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class PartType extends \yii\db\ActiveRecord
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
        return 'part_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['part_name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['part_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_name' => '配件类型名称',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public static function getAllPartTypeList()
    {
    	$types = self::find()->all();
    	return ArrayHelper::map($types, 'id', 'part_name');
    }
}
