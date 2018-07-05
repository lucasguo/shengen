<?php
/**
 * Created by PhpStorm.
 * User: Liubin
 * Date: 2017/7/7
 * Time: 22:40
 */

namespace backend\models;


class FinanceNew extends Finance
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_new';
    }
}