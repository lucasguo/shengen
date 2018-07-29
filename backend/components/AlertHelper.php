<?php
namespace backend\components;

use Yii;
use yii\base\Component;
use common\models\Alert;

class AlertHelper extends Component
{
	
	public function getMyTodayAlertCount()
	{
		$today = date('Y-m-d');
		return Yii::$app->db->createCommand('
		    SELECT COUNT(*) FROM alert WHERE alert_date=:alert_date and userid=:userid
		', [':alert_date' => $today, ':userid' => Yii::$app->user->id])->queryScalar();
	}
	
	public function getMyTodayAlerts()
	{
		$today = date('Y-m-d');
		return Alert::findAll(['alert_date' => $today, 'userid' => Yii::$app->user->id]);
	}
}