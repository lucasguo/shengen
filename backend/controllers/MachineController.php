<?php

namespace backend\controllers;

use backend\models\AmendRecordSearch;
use Yii;
use backend\models\MachineMaster;
use backend\models\MachineForm;
use backend\models\MachineMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\ProductPartType;
use backend\models\PartType;
use backend\models\ExtraFieldsForm;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\models\MachineProduct;
use backend\models\Part;
use backend\models\MachinePart;

/**
 * MachineController implements the CRUD actions for MachineMaster model.
 */
class MachineController extends Controller
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
        				'roles' => ['manageMachine'],
        			]
        		],
        	],
        ];
    }

    /**
     * Lists all MachineMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MachineMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
        	'products' => MachineProduct::getAllProductList(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MachineMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$master = $this->findModel($id);
    	$model = $master->prepareMachineForm();
    	$searchModel = new AmendRecordSearch();
        $searchModel->machine_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $model,
        	'machineId' => $master->id,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MachineMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($productId)
    {
        $model = new MachineMaster();
        $model->product_id = $productId;
        $model->in_datetime = date('Y-m-d');
        $model->machine_cost = Yii::$app->params['productCost'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
//        $model = new MachineForm();
//        $model->productId = $productId;
//        $types = ProductPartType::getProductPartTypesById($productId);
//        $model->updateFields(ArrayHelper::getColumn($types, 'part_name'));
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//        	$machine = $model->toMachineMaster();
//        	if($machine->save()) {
//        		for($i = 0; $i < count($types); $i++) {
//        			$fieldname = "field" . ($i + 1);
//        			$part = new Part();
//        			$part->part_sn = $model->$fieldname;
//        			$part->part_type = $types[$i]->id;
//        			$part->save();
//        			$rel = new MachinePart();
//        			$rel->machine_id = $machine->id;
//        			$rel->part_id = $part->id;
//        			$rel->part_type_id = $types[$i]->id;
//        			$rel->save();
//        		}
//        	} else {
//        		foreach ($machine->getErrors() as $attr => $errors) {
//        			Yii::$app->session->setFlash("error", $errors[0]);
//        		}
//        		return $this->render('create', [
//        			'model' => $model,
//        		]);
//        	}
//            return $this->redirect(['view', 'id' => $machine->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing MachineMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $master = $this->findModel($id);
        $model = $master->prepareMachineForm();
        
        if ($model->load(Yii::$app->request->post())) {
        	$master->machine_cost = $model->machineCost;
        	$master->machine_sn = $model->machineSn;
        	if($master->save()) {
            	return $this->redirect(['view', 'id' => $master->id]);
        	} else {
        		foreach ($master->getErrors() as $attr => $errors) {
        			Yii::$app->session->setFlash("error", $errors[0]);
        		}
        		return $this->render('update', [
        			'model' => $model,
        		]);
        	}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
//     public static function prepareMachineForm($master)
//     {
//     	$model = new MachineForm();
//     	$model->fromMachineMaster($master);
//     	$types = $this->getProductPartTypesById($master->product_id);
//     	$model->updateFields(ArrayHelper::getColumn($types, 'part_name'));
//     	for($i = 0; $i < count($types); $i ++) {
//     		$fieldname = 'field' . ($i + 1);
//     		$partId = MachinePart::findOne(['machine_id' => $master->id, 'part_type_id' => $types[$i]->id])->part_id;
//     		$model->$fieldname = Part::findOne($partId)->part_sn;
//     	}
//     	return $model;
//     }

    /**
     * Deletes an existing MachineMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

    /**
     * Finds the MachineMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MachineMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MachineMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
//     protected function getProductPartTypesById($id)
//     {
//     	$typeIds = ProductPartType::findAll(['product_id' => $id]);
//     	return PartType::find()->where(['in', 'id', ArrayHelper::getColumn($typeIds, 'part_type_id')])->orderBy('id')->all();
//     }
}
