<?php

namespace backend\controllers;

use backend\models\CardBuyerInfoSearch;
use Yii;
use backend\models\DealerShop;
use backend\models\DealerShopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DealerShopController implements the CRUD actions for DealerShop model.
 */
class DealerShopController extends Controller
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
        				'roles' => ['maintainDealerShop'],
        			]
        		],
        	],
        ];
    }
    
//     public function beforeAction($action)
//     {
//     	if ($action->id == 'region') {
//     		$this->enableCsrfValidation = false;
//     	}
    
//     	return parent::beforeAction($action);
//     }
    
    public function actions()
    {
    	$actions=parent::actions();
    	$actions['get-region']=[
    		'class'=>\chenkby\region\RegionAction::className(),
    		'model'=>\backend\models\Region::className()
    	];
    	return $actions;
    }

    /**
     * Lists all DealerShop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DealerShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DealerShop model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new CardBuyerInfoSearch();
        $data = $searchModel->searchInfo($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
        ]);
    }

    /**
     * Creates a new DealerShop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DealerShop();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DealerShop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DealerShop model.
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
     * Finds the DealerShop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DealerShop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DealerShop::find()->where(['id' => $id])->with('cityRegion')->with('provinceRegion')->with('regionRegion')->with('opener')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
