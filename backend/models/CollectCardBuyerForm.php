<?php
namespace backend\models;

use yii\helpers\ArrayHelper;

class CollectCardBuyerForm extends CardBuyer
{
    public $cardType;
    public $cardNo;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),[
            [['cardType', 'cardNo'], 'required']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'cardType' => '理疗卡类型',
            'cardNo' => '卡号'
        ]);
    }
}