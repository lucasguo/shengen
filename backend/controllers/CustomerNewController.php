<?php

namespace backend\controllers;

use backend\models\CustomerMaintainNewForm;
use Yii;
use backend\models\CustomerNew;
use backend\models\CustomerNewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use backend\models\CustomerMaintainNew;
use common\models\Alert;

/**
 * CustomerNewController implements the CRUD actions for CustomerNew model.
 */
class CustomerNewController extends Controller
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
        ];
    }

    public function actionIndex($type)
    {
        if ($type == null) {
            $type = CustomerNew::TYPE_COMPANY;
        }
        $searchModel = new CustomerNewSearch();
        $searchModel->customer_type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    /**
     * Displays a single CustomerNew model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $count = Yii::$app->db->createCommand('
		    SELECT COUNT(*) FROM customer_maintain_new WHERE customer_id=:cid
		', [':cid' => $id])->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT c.content, c.created_at, u.username FROM customer_maintain_new c left join user u on c.created_by=u.id WHERE c.customer_id=:cid',
            'params' => [':cid' => $id],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'created_at' => [
                        'default' => SORT_DESC,
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($type)
    {
        $model = new CustomerNew();
        $model->customer_type = $type;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '成功添加' . $model->customer_name);
            return $this->redirect(['index', 'type' => $model->customer_type]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'type' => $type,
            ]);
        }
    }

    /**
     * Updates an existing CustomerNew model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '成功更新' . $model->customer_name);
            return $this->redirect(['index', 'type' => $model->customer_type]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'type' => $model->customer_type,
            ]);
        }
    }

    /**
     * Deletes an existing CustomerNew model.
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
     * Finds the CustomerNew model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerNew the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerNew::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMaintain($id)
    {
        $customer = $this->findModel($id);
        $customerName = $customer->customer_name;
        $model = new CustomerMaintainNewForm();
        $model->alert_time = intval(date('H'));

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $maintain = new CustomerMaintainNew();
                $maintain->customer_id = $id;
                $maintain->content = $model->content;
                $maintain->save();
                if($model->add_alert === '1')
                {
                    $alert = new Alert();
                    $alertContent = "维护" . $customerName;
                    if(!empty($model->alert_content)) {
                        $alertContent .= " - " . $model->alert_content;
                    } else {
                        $alertContent .= " - " . $maintain->content;
                    }
                    $alert->content = $alertContent;
                    $alert->alert_date = $model->alert_date;
                    $alert->alert_time = $model->alert_time;
                    $alert->userid = Yii::$app->user->id;
                    $alert->save();
                }
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('maintain', [
            'model' => $model,
            'customerName' => $customerName,
        ]);
    }
}