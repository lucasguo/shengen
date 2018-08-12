<?php

namespace backend\controllers;

use Yii;
use backend\models\MachineProduct;
use backend\models\ProductForm;
use backend\models\MachineProductSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\ProductPartType;

/**
 * ProductController implements the CRUD actions for MachineProduct model.
 */
class ProductController extends Controller
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
        				'allow' => true,
        				'roles' => ['adminSite'],
        			]
        		],
        	],
        ];
    }

    /**
     * Lists all MachineProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MachineProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MachineProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$form = new ProductForm();
    	$partTypes = ProductPartType::findAll(["product_id" => $id]);
    	$index = 1;
    	foreach ($partTypes as $type) {
    		if($index > 4) {
    			break;
    		}
    		$attr = "partType" . $index;
    		$form->$attr = $type->part_type_id;
    		$index ++;
    	}
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'form' => $form,
        ]);
    }

    /**
     * Creates a new MachineProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MachineProduct();
        $form = new ProductForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()
        		&& $form->load(Yii::$app->request->post()) && $form->validate()) {
        	$model->save();
        	$form->save($model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'prodForm' => $form,
            ]);
        }
    }

    /**
     * Updates an existing MachineProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new ProductForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()
        		&& $form->load(Yii::$app->request->post()) && $form->validate()) {
        	$model->save();
        	$form->save($model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	$partTypes = ProductPartType::findAll(["product_id" => $id]);
        	$index = 1;
        	foreach ($partTypes as $type) {
        		if($index > 4) {
        			break;
        		}
        		$attr = "partType" . $index;
        		$form->$attr = $type->part_type_id;
        		$index ++;
        	}
            return $this->render('update', [
                'model' => $model,
            	'prodForm' => $form,
            ]);
        }
    }

    /**
     * Finds the MachineProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MachineProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MachineProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
