<?php

namespace backend\controllers;

use backend\models\EmployeeSignupForm;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EmployeeController implements the CRUD actions for User model.
 */
class EmployeeController extends Controller
{

    public static function getAvailableRoles()
    {
        return [
            'dealerEmployee' => '员工',
            'dealer' => '管理员',
        ];
    }
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
                        'roles' => ['addEmployee'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $searchModel = new UserSearch();
        $searchModel->shop_id = $shopId;
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
     * @throws ForbiddenHttpException
     */
//    public function actionView($id)
//    {
//        $shopId = Yii::$app->user->identity->shop_id;
//        if (empty($shopId)) {
//            throw new ForbiddenHttpException('The requested page does not exist.');
//        }
//        $user = $this->findModel($id);
//        if ($user->shop_id != $shopId) {
//            throw new ForbiddenHttpException('The requested page does not exist.');
//        }
//        return $this->render('view', [
//            'model' => $user,
//        ]);
//    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        $model = new EmployeeSignupForm();
        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $count = User::find()->where(['shop_id' => $shopId])->count();
        if ($count >= Yii::$app->params['employeeCountLimit']) {
            Yii::$app->session->setFlash('error', '超过员工限制，无法创建更多员工');
            return $this->redirect(['index']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->signup($shopId) != null) {
            Yii::$app->session->setFlash('success', '成功添加员工' . $model->username);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);

        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        if ($user->shop_id != $shopId) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $model = new EmployeeSignupForm();
        $model->fromUser($user);
        $model->userId = $id;
        if ($model->load(Yii::$app->request->post()) && $model->signup($shopId) != null) {
            Yii::$app->session->setFlash('success', '成功更新员工' . $model->username);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        if ($model->shop_id != $shopId) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $model->delete();

        return $this->redirect(['index']);
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
