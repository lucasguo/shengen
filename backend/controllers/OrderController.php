<?php

namespace backend\controllers;

use backend\models\MachineForm;
use Yii;
use yii\base\Model;
use backend\models\OrderMaster;
use backend\models\OrderDetail;
use backend\models\OrderForm;
use backend\models\OrderMasterSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Customer;
use backend\models\MachineMaster;
use backend\models\MachineProduct;
use backend\models\Finance;
use backend\models\UserRelation;
use backend\models\ProductPartType;
use backend\models\Part;
use backend\models\MachinePart;

/**
 * OrderController implements the CRUD actions for OrderMaster model.
 */
class OrderController extends Controller
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
        				'actions' => ['create'],
        				'allow' => true,
        				'roles' => ['addOrder'],
        			],
        			[
	        			'actions' => ['update', 'delete', 'confirm'],
	        			'allow' => true,
	        			'roles' => ['updateOrder'],
        			],
        			[
	        			'actions' => ['index', 'view'],
	        			'allow' => true,
	        			'roles' => ['addOrder', 'updateOrder'],
        			],
        			[
        				'actions' => ['out-index', 'out', 'export', 'finish'],
        				'allow' => true,
        				'roles' => ['manageMachine'],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all OrderMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all OrderMaster models.
     * @return mixed
     */
    public function actionOutIndex()
    {
    	$searchModel = new OrderMasterSearch();
    	$searchModel->status_set = [OrderMaster::STATUS_CONFIRMED, OrderMaster::STATUS_PREPARE_OUT];
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('out-index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	$machineSn = '';
    	$details = OrderDetail::findAll(['master_id' => $id]);
    	$machineSns = [];
    	foreach ($details as $detail) {
    		$machineSns[] = MachineMaster::findOne(['id' => $detail->machine_id])->machine_sn;
    	}
    	$machineSn = implode(", ", $machineSns);
        return $this->render('view', [
            'model' => $model,
        	'machineSn' => $machineSn,
        ]);
    }

    /**
     * Creates a new OrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderForm();
        $model->warranty_in_month = 12;

        if ($model->load(Yii::$app->request->post()) && $model->generateSn()) {
//         	$detail = new OrderDetail();
//         	$detail->master_id = $model->id;
//         	$detail->machine_id = $model->machine_id;
//         	$detail->sold_price = $model->sold_amount;
//         	$detail->save();
			$model->product_id = MachineProduct::getDefaultProduct()->id;
            $model->order_status = OrderMaster::STATUS_CONFIRMED;
			if ($model->save()) {

//				if($model->add_to_finance === "1") {
                $finance = new Finance();
                $finance->amount = $model->sold_amount;
                $finance->content = '订单编号： ' . $model->order_sn;
                $finance->occur_date = $model->getsoldDate();
                $finance->relate_table = $model->tableName();
                $finance->relate_id = $model->id;
                $finance->type = Finance::TYPE_ORDER;
                $finance->save();
//				}
                $customer = Customer::findOne($model->customer_id);
                $customer->customer_status = Customer::STATUS_BOUGHT;
                $customer->setScenario("update");
                $customer->save();
	            return $this->redirect(['view', 'id' => $model->id]);
			}
        }
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing OrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
// 		$model->initMachines();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//         	OrderDetail::deleteAll(['master_id' => $model->id]);
//         	$detail = new OrderDetail();
//         	$detail->master_id = $model->id;
//         	$detail->machine_id = $model->machine_id;
//         	$detail->sold_price = $model->sold_amount;
//         	$detail->save();
			$relateFinance = Finance::findOne(['relate_table' => $model->tableName(), 'relate_id' => $id]);
			if($relateFinance && $relateFinance->amount != $model->sold_amount) {
				$relateFinance->amount = $model->sold_amount;
				$relateFinance->save();
			}
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing OrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionOut($id)
    {
    	$model = $this->findModel($id);
    	$form = $model->getOuterOrderForm();
    	// 		$model->initMachines();
    	if ($form->load(Yii::$app->request->post()) && $form->validate()) {
    		$transaction = Yii::$app->db->beginTransaction();
    		try {
    			foreach ($form->machines as $machineId)
    			{
    				$detail = new OrderDetail();
    				$detail->machine_id = $machineId;
    				$detail->master_id = $id;
    				$detail->save();
    				$machine = MachineMaster::findOne($machineId);
    				$machine->machine_status = MachineMaster::STATUS_SOLD;
    				$machine->out_datetime = date('Y-m-d');
    				$machine->save();
    			}
    			/* @var $customer Customer */
    			$customer = Customer::findOne($model->customer_id);
    			$customer->scenario = 'update';
    			$customer->customer_status = Customer::STATUS_BOUGHT;
    			$customer->save();
    			$model->order_status = OrderMaster::STATUS_PREPARE_OUT;
    			$model->save();
    			$transaction->commit();
    		} catch (Exception $e) {
    			$transaction->rollBack();
    			Yii::$app->session->setFlash('error', '服务器错误，出库失败，请联系管理员。');
    			return $this->render('out-create', [
    				'model' => $form,
    				'orderSn' => $model->order_sn,
    			]);
    		}
    		return $this->redirect(['out-index']);
    	} else {
    		if($form->hasErrors('errorHook'))
    		{
    			Yii::$app->session->setFlash('error', $form->getFirstError('errorHook'));
    		}
    		return $this->render('out-create', [
    			'model' => $form,
    			'orderSn' => $model->order_sn,
    		]);
    	}
    }

    /**
     * Deletes an existing OrderMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	OrderDetail::deleteAll(['master_id' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionConfirm($id) {
    	$order = $this->findModel($id);
    	$order->order_status = OrderMaster::STATUS_CONFIRMED;
    	$order->save();
    	$finance = new Finance();
    	$finance->amount = $order->sold_amount;
    	$finance->content = '订单编号： ' . $order->order_sn;
    	$finance->occur_date = $order->getsoldDate();
    	$finance->relate_table = $order->tableName();
    	$finance->relate_id = $order->id;
    	$finance->type = Finance::TYPE_ORDER;
    	$finance->save();
    	$customer = Customer::findOne($order->customer_id);
    	$customer->customer_status = Customer::STATUS_BOUGHT;
    	$customer->setScenario("update");
    	$customer->save();
    	$user = User::findOne(['customer_id' => $customer->id]);
    	if ($user != null) {
	    	$userid = $user->id;
	    	if ($customer->auto_convert) {
	    		User::sendRegSms($user->id);
	    	}
	    	$relation = UserRelation::findOne(['left_id' => $userid]);
	    	if ($relation != null) {
	    		$relation->left_status = UserRelation::STATUS_CONFIRMED;
	    		$relation->left_confirm_date = date('Y-m-d');
	    		$relation->save();
	    	} else {
	    		$relation = UserRelation::findOne(['right_id' => $userid]);
	    		if ($relation != null) {
	    			$relation->right_status = UserRelation::STATUS_CONFIRMED;
	    			$relation->right_confirm_date = date('Y-m-d');
	    			$relation->save();
	    		}
	    	}
	    	// TODO: calc money here?
    	}
    	return $this->redirect(['index']);
    }
    
    public function actionExport($id)
    {
    	$model = $this->findModel($id);
		$file = Yii::$app->export->exportOrder($model);
		if($file == null) {
			throw new InvalidCallException("报表尚未定义，请联系管理员");
		} else {
	    	Yii::$app->response->sendFile($file, $model->order_sn . '.xlsx', [
	    		'mimeType' => 'application/vnd.ms-excel',
	    	]);
		}
    }
    
    public function actionFinish($id)
    {
        $details = OrderDetail::find()->select('machine_id')->where(['master_id' => $id])->asArray()->all();
        $machines = [];
        foreach ($details as $detail) {
            $machineId = $detail['machine_id'];
            $machine = MachineMaster::findOne($machineId);
            $form = $machine->prepareMachineForm();
            $form->setScenario('update');
            $machines["machine$machineId"] = $form;
            $productId = $machine->product_id;
        }
        if (Model::loadMultiple($machines, Yii::$app->request->post()) && Model::validateMultiple($machines)) {
            $types = ProductPartType::getProductPartTypesById($productId);
            /* @var $machine MachineForm */
            $txn = Yii::$app->db->beginTransaction();
            $success = true;
            foreach ($machines as $key => $machine) {
                for($i = 0; $i < count($types); $i++) {
        			$fieldname = "field" . ($i + 1);
        			$part = new Part();
        			$part->part_sn = $machine->$fieldname;
        			$part->part_type = $types[$i]->id;
        			if ($part->save()) {
                        $rel = new MachinePart();
                        $rel->machine_id = $machine->machineId;
                        $rel->part_id = $part->id;
                        $rel->part_type_id = $types[$i]->id;
                        if (!$rel->save()) {
                            Yii::$app->session->addFlash('error', '仪器' . $machine->machineSn . '的配件编号输入有误');
                            $success = false;
                        }
                    } else {
                        Yii::$app->session->addFlash('error', '仪器' . $machine->machineSn . '的配件编号输入有误');
                        $success = false;
                    }
        		}
            }
            if ($success) {
                $order = $this->findModel($id);
                $order->order_status = OrderMaster::STATUS_INSTALLED;
                $order->save();
                $txn->commit();
                Yii::$app->session->addFlash('success', '订单和仪器更新成功');
                return $this->redirect(['out-index']);
            } else {
                $txn->rollBack();
            }
        }
        return $this->render('finish', [
            'machines' => $machines,
        ]);
    }

    /**
     * Finds the OrderMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
