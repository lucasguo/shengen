<?php

namespace backend\controllers;

use backend\models\DealerShop;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        	'access' => [
        		'class' => AccessControl::className(),
        		'rules' => [
        			[
	        			'allow' => true,
	        			'roles' => ['manageUser'],
        			]
        		],
        	],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
        	$model->generateAuthKey();
        	$model->password_hash = '';
        	if ($model->save()) {
                foreach ($model->roles as $rolename) {
                    $role = Yii::$app->authManager->getRole($rolename);
                    Yii::$app->authManager->assign($role, $model->id);
                }
                if (User::sendRegSms($model->id)) {
                    Yii::$app->session->addFlash('success', '用户' . $model->username . '创建成功');
                } else {
                    Yii::$app->session->addFlash('success', '用户' . $model->username . '创建成功，但未能发送通知短信，请联系管理员');
                }
                return $this->redirect(['index']);
            }
        }
        if (!empty($model->shop_id)) {
            $shopName = DealerShop::findOne($model->shop_id)->name;
        } else {
            $shopName = '';
        }
        return $this->render('create', [
            'model' => $model,
            'shopName' => $shopName,
        ]);
    }
    
    public function actionResendSms($id)
    {
    	Yii::$app->response->format = Response::FORMAT_JSON;
    	$ret = User::sendRegSms($id);
    	if($ret) {
    		return ['status' => 'ok'];
    	} else {
    		return ['status' => 'error'];
    	}
    }
    


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->authManager->revokeAll($id);
        	foreach ($model->roles as $rolename) {
        		$role = Yii::$app->authManager->getRole($rolename);
        		Yii::$app->authManager->assign($role, $id);
        	}
        	Yii::$app->session->setFlash('success', '用户' . $model->username . '信息更新成功');
            return $this->redirect(['index']);
        } else {
        	$roles = Yii::$app->authManager->getRolesByUser($id);
        	$model->roles = ArrayHelper::getColumn($roles, 'name');
        	if (!empty($model->shop_id)) {
        	    $shopName = DealerShop::findOne($model->shop_id)->name;
            } else {
        	    $shopName = '';
            }
            return $this->render('update', [
                'model' => $model,
                'shopName' => $shopName
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Disable an existing User model.
     * If the disable is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
//     	$uesr = $this->findModel($id);
//     	$user->status = User::STATUS_DELETED;
//     	$user->save();
    	User::updateAll(['status' => User::STATUS_DELETED], ['id' => $id]);
    
    	return $this->redirect(['index']);
    }
    
    /**
     * Enable an existing User model.
     * If the enable is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEnable($id)
    {
//     	$uesr = $this->findModel($id);
//     	$user->status = User::STATUS_ACTIVE;
//     	$user->save();
    	User::updateAll(['status' => User::STATUS_ACTIVE], ['id' => $id]);
    	
    	return $this->redirect(['index']);
    }

    public function actionObo($id)
    {
        $oboUser = $this->findModel($id);
        Yii::$app->session->set(User::OBO_KEY, Yii::$app->user->id);
        Yii::$app->user->login($oboUser, 3600 * 24 * 30);
        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
