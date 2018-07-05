<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\UpdateEmailForm;
use backend\models\UpdatePasswordForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'update-password', 'update-email', 'exit-obo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = '//main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
    	$this->layout = '//main-login';
    	$model = new PasswordResetRequestForm();
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		if ($model->sendEmail()) {
    			Yii::$app->session->setFlash('success', '包含重置密码请求的邮件已发送。');
    
    			return $this->goHome();
    		} else {
    			Yii::$app->session->setFlash('error', '抱歉，无法发送邮件。');
    		}
    	}
    
    	return $this->render('requestPasswordResetToken', [
    		'model' => $model,
    	]);
    }
    
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
    	$this->layout = '//main-login';
    	try {
    		$model = new ResetPasswordForm($token);
    	} catch (InvalidParamException $e) {
    		throw new BadRequestHttpException($e->getMessage());
    	}
    
    	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    		Yii::$app->session->setFlash('success', '新密码已生效');
    
    		return $this->goHome();
    	}
    
    	return $this->render('resetPassword', [
    		'model' => $model,
    	]);
    }
    
    public function actionUpdatePassword()
    {
    	$model = new UpdatePasswordForm();
    	 
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->validate()) {
    			$user = User::findOne(Yii::$app->user->id);
    			$user->setPassword($model->newPassword);
    			$user->save();
    			Yii::$app->session->setFlash("success", "修改密码成功");
    		}
    	}
    
    	return $this->render('updatePassword', [
    		'model' => $model,
    	]);
    }
    
    public function actionUpdateEmail()
    {
    	$model = new UpdateEmailForm();
    
    	$model->username = Yii::$app->user->identity->username;
    	$model->mobile = Yii::$app->user->identity->mobile;
    	$model->email = Yii::$app->user->identity->email;
    	
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->validate()) {
    			$user = User::findOne(Yii::$app->user->id);
    			$user->email = $model->email;
    			$user->save();
    			Yii::$app->session->setFlash("success", "修改资料成功");
    		}
    	}
    
    	return $this->render('updateEmail', [
    		'model' => $model,
    	]);
    }

    public function actionExitObo() {
        $orgId = Yii::$app->session->get(User::OBO_KEY);
        if ($orgId != null) {
            Yii::$app->session->remove(User::OBO_KEY);
            $user = User::findOne($orgId);
            Yii::$app->user->login($user);
        }
        return $this->goHome();
    }
}
