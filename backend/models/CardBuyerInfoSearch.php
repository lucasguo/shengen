<?php
namespace backend\models;

use MongoDB\Driver\Query;
use yii\db\Expression;

class CardBuyerInfoSearch
{
    /**
     * @param $shopId int
     * @return array
     * [0] => card info
     * [1] => card statistics this month
     * [2] => card statistics this year
     * [3] => employee info
     * [4] => employee statistics this month
     */
    public function searchInfo($shopId)
    {
        $ret = [];
        $cardTypes = \backend\models\CardType::find()->select(['id','name'])->orderBy('id')->asArray()->all();
        $ret[] = $cardTypes;
        $monthBegin = mktime(0, 0, 0, date('m'), 1);
        $yearBegin = mktime(0, 0, 0, 1, 1);
        $cardMonthResult = [];
        foreach ($cardTypes as $cardType) {
            $cardTypeId = $cardType['id'];
            $cardMonthResult["count$cardTypeId"] = Card::find()->where(['>=', 'created_at', $monthBegin])->andWhere(['shop_id' => $shopId])->andWhere(['card_type' => $cardTypeId])->count();
        }
        $ret[] = $cardMonthResult;

        $cardYearResult = [];
        foreach ($cardTypes as $cardType) {
            $cardTypeId = $cardType['id'];
            $cardYearResult["count$cardTypeId"] = Card::find()->where(['>=', 'created_at', $yearBegin])->andWhere(['shop_id' => $shopId])->andWhere(['card_type' => $cardTypeId])->count();
        }
        $ret[] = $cardYearResult;

        $employees = \common\models\User::find()->select(['id', 'username'])->where(['shop_id' => $shopId])->asArray()->all();
        $ret[] = $employees;
        $cardEmployeeResult = [];
        foreach ($employees as $employee) {
            $employeeId = $employee['id'];
            foreach ($cardTypes as $cardType) {
                $cardTypeId = $cardType['id'];
                $cardEmployeeResult["count$employeeId" . "_" . $cardTypeId] = Card::find()->where(['>=', 'created_at', $monthBegin])->andWhere(['shop_id' => $shopId])->andWhere(['created_by' => $employeeId])->andWhere(['card_type' => $cardTypeId])->count();
            }
        }
        $ret[] = $cardEmployeeResult;

        return $ret;
    }

    public function searchAll()
    {

    }
}