<?php
namespace backend\models;

use yii\base\Model;
use backend\models\Part;

class AmendForm extends Model
{
    public $amendType;
    public $oldPartId;
    public $newPartSn;
    public $comment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $replaceType = AmendRecord::TYPE_REPLACE;
        $fixType = AmendRecord::TYPE_FIX;
        return [
            ['amendType', 'default', 'value' => AmendRecord::TYPE_FIX],
            ['amendType', 'in', 'range' => [AmendRecord::TYPE_FIX, AmendRecord::TYPE_REPLACE]],
            [['newPartSn', 'comment'], 'string'],
            ['newPartSn', 'unique', 'targetClass' => Part::className(), 'targetAttribute' => 'part_sn'],
            ['oldPartId', 'required'],
            ['oldPartId', 'validPartId'],
            [
                ['newPartSn'],
                'required',
                'when' => function ($model) { return $model->amendType == AmendRecord::TYPE_REPLACE; },
                'whenClient' => "function (attribute, value) { return $('#amendType').val() == $replaceType; }"
            ],
            [
                ['comment'],
                'required',
                'when' => function ($model) { return $model->amendType == AmendRecord::TYPE_FIX; },
                'whenClient' => "function (attribute, value) { return $('#amendType').val() == $fixType; }"
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'amendType' => '维修类型',
            'oldPartId' => '维修部位',
            'newPartSn' => '新配件编号',
            'comment' => '维修记录',
        ];
    }

    public function validPartId($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $part = Part::findOne($this->oldPartId);
            if ($part != null && $part->status == Part::STATUS_BROKEN) {
                if ($part == null) {
                    $this->addError($attribute, '无效的配件');
                }
            }
            if ($this->amendType == AmendRecord::TYPE_REPLACE) {
                if ($part == null) {
                    $this->addError($attribute, '无效的配件');
                }
            } elseif ($this->amendType == AmendRecord::TYPE_FIX) {
                if ($part == null && $this->oldPartId != AmendRecord::PART_OTHER) {
                    $this->addError($attribute, '无效的配件');
                }
            }
        }
    }
}