<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\behaviors\CloseFilter;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        	'close' => [
        		'class' => CloseFilter::className(),
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'blank';
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
//     public function actionLogin()
//     {
//         if (!Yii::$app->user->isGuest) {
//             return $this->goHome();
//         }

//         $model = new LoginForm();
//         if ($model->load(Yii::$app->request->post()) && $model->login()) {
//             return $this->goBack();
//         } else {
//             return $this->render('login', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
//     public function actionLogout()
//     {
//         Yii::$app->user->logout();

//         return $this->goHome();
//     }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', '感谢您的反馈');
            } else {
                Yii::$app->session->setFlash('error', '无法发信给管理员');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionClose()
    {
    	return $this->render('close');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
//     public function actionSignup()
//     {
//         $model = new SignupForm();
//         if ($model->load(Yii::$app->request->post())) {
//             if ($user = $model->signup()) {
//                 if (Yii::$app->getUser()->login($user)) {
//                     return $this->goHome();
//                 }
//             }
//         }

//         return $this->render('signup', [
//             'model' => $model,
//         ]);
//     }


}
