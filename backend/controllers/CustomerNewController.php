<?php

namespace backend\controllers;

use backend\models\CustomerMaintainNewForm;
use backend\models\CustomerNewExtend;
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
use yii2fullcalendar\models\Event;

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['adminSite'],
                    ]
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
            'sql' => '
SELECT 
CASE
  WHEN c.alert_id is null then c.content
  WHEN c.alert_id is not null then CONCAT(c.content, \'\n(\', a.alert_date, \' \', a.content, \')\')
END as content, 
c.created_at, u.username 
FROM customer_maintain_new c 
left join user u on c.created_by=u.id
left join alert a on c.alert_id = a.id
WHERE c.customer_id=:cid',
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
            'extend' => CustomerNewExtend::findOne(['customer_id' => $id]),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($type)
    {
        $model = new CustomerNew();
        $model->customer_type = $type;
        $modelLoaded = $model->load(Yii::$app->request->post());
        $extend = new CustomerNewExtend();
        if ($extend->load(Yii::$app->request->post())) {
            $model->extend = $extend;
        }
        if ($modelLoaded && $model->save()) {
            Yii::$app->session->setFlash('success', '成功添加' . $model->customer_name);
            return $this->redirect(['index', 'type' => $model->customer_type]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'extend' => $extend,
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
        $modelLoaded = $model->load(Yii::$app->request->post());
        $extend = CustomerNewExtend::findOne(['customer_id' => $id]);
        if ($extend == null) {
            $extend = new CustomerNewExtend();
        }
        if ($extend->load(Yii::$app->request->post())) {
            $model->extend = $extend;
        }
        if ($modelLoaded && $model->save()) {
            Yii::$app->session->setFlash('success', '成功更新' . $model->customer_name);
            return $this->redirect(['index', 'type' => $model->customer_type]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'extend' => $extend,
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
        $model = $this->findModel($id);
        $type = $model->customer_type;
        $model->delete();
        return $this->redirect(['index', 'type' => $type]);
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
                    $maintain->alert_id = $alert->id;
                }
                $maintain->save();
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('maintain', [
            'model' => $model,
            'customerName' => $customerName,
            'customerType' => $customer->customer_type,
        ]);
    }

    public function actionCalendar() {
        $alerts = Alert::findAll(['userid' => Yii::$app->user->id]);
        $events = [];
        foreach ($alerts as $alert) {
            $event = new Event();
            $event->id = $alert->id;
            $event->title = $alert->content;
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($alert->alert_date . ' ' . $alert->alert_time . ':00:00'));
            $events[] = $event;
        }
        return $this->render('calendar', [
            'events' => $events,
        ]);
    }
}
