<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use common\models\LoginForm;
use backend\models\WechatConnect;

class WechatController extends Controller
{
	public function actionVerify()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		
		if(Yii::$app->request->get('code') == null) {
			$loginUrl = Url::to(['wechat/verify'], true);
			$oauthUrl = Yii::$app->wechat->getOauth2AuthorizeUrl($loginUrl, $state = 'authorize', $scope = 'snsapi_base');
			Yii::trace("oauth url: " . $oauthUrl);
			return $this->redirect($oauthUrl);
		} else {
			$code = Yii::$app->request->get('code');
			Yii::trace("code get: " . $code);
			$oauthInfo = Yii::$app->wechat->getOauth2AccessToken($code);
			Yii::trace("oauth get: " . var_export($oauthInfo, true));
			$openid = $oauthInfo['openid'];
			$connect = WechatConnect::findOne(['openid' => $openid]);
			if($connect == null) {
				Yii::$app->session->open();
				Yii::$app->session->set('openid', $openid);
				return $this->redirect(['login']);
			}
			$user = User::findOne($connect->userid);
			Yii::$app->user->login($user, 3600 * 24 * 30);
			return $this->goHome();
		}
	}
	
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$openid = Yii::$app->session->get("openid");
		if (empty($openid)) {
			return $this->redirect(['verify']);
		}
		$this->layout = '//main-login';
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$connect = new WechatConnect();
			$connect->userid = Yii::$app->user->id;
			$connect->openid = $openid;
			$connect->save();
			return $this->goHome();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}
}