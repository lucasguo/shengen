<?php
namespace frontend\behaviors;

use Yii;
use yii\base\ActionFilter;

class CloseFilter extends ActionFilter
{
	public function beforeAction($action)
	{
		if ($action->id != 'close' && Yii::$app->params['siteClosed']) {
			Yii::$app->response->redirect(['site/close']);
			return false;
		}
		return true;
	}
}