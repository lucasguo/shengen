<?php
/**
 * Created by PhpStorm.
 * User: Liubin
 * Date: 2018/7/28
 * Time: 19:36
 */

namespace console\controllers;

use backend\models\WechatConnect;
use common\models\Alert;
use common\models\User;
use yii\console\Controller;
use Yii;

class AlertController extends Controller
{
    const TEMPLATE_ID = 'GLleCIa6GAZ0Qx0FdVsFKVin8IebsNr1C2QhnvVGAD4';

    public function actionSend() {
        $today = date('Y-m-d');
        $time = intval(date('H'));
        $alerts = Alert::findAll(['alert_date' => $today, 'alert_time' => $time]);
        if ($alerts == null || count($alerts) <= 0) {
            echo "没有需要提醒的数据";
            return;
        }
        foreach ($alerts as $alert) {
            $user = User::findIdentity($alert->userid);
            $connect = WechatConnect::findOne(['userid' => $alert->userid]);
            if ($user != null && $connect != null) {
                $data = [
                    "first" => [
                        "value" => "您设定的备忘录已触发",
                    ],
                    "keyword1" => [
                        "value" => "待处理",
                    ],
                    "keyword2" => [
                        "value" => date('Y年m月d日', $alert->created_at),
                    ],
                    "keyword3" => [
                        "value" => "无",
                    ],
                    "keyword4" => [
                        "value" => "备忘录",
                    ],
                    "keyword5" => [
                        "value" => $user->username,
                    ],
                    "remark" => [
                        "value" => $alert->content,
                    ]
                ];
                Yii::$app->wechat->sendTemplateMessage($connect->openid, self::TEMPLATE_ID, $data);
            }
        }
    }
}