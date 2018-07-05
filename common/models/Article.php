<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $category
 * @property integer $is_top
 * @property string $title
 * @property string $source
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Article extends \yii\db\ActiveRecord
{
    const CATEGORY_ACADEMIC = 0;
    const CATEGORY_PRODUCT = 1;
    const CATEGORY_HEALTH = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

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
    public function rules()
    {
        return [
            [['category', 'is_top', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['source'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => '类别',
            'is_top' => '是否置顶',
            'title' => '标题',
            'source' => '来源',
            'content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getCategoryList()
    {
        return [
            self::CATEGORY_ACADEMIC => '学术新闻',
            self::CATEGORY_PRODUCT => '产品动态',
            self::CATEGORY_HEALTH => '健康新闻',
        ];
    }

    public function getCategoryLabel()
    {
        return static::getCategoryList()[$this->category];
    }
}
