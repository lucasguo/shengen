<?php

namespace backend\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "region".
 *
 * @property string $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $level
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'parent_id', 'level'], 'required'],
            [['id', 'parent_id', 'level'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    
    public static function getRegion($parentId=0)
    {
    	$result = static::find()->where(['parent_id'=>$parentId])->asArray()->all();
    	return ArrayHelper::map($result, 'id', 'name');
    }

    public static function getFujianCities()
    {
        return self::getRegion(16);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'level' => 'Level',
        ];
    }
}
