<?php

namespace backend\controllers;

use Yii;
use backend\models\BonusSetting;
use backend\models\BonusSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\MachineProduct;
use backend\helpers\BonusHelper;
use backend\models\UserBonus;
use backend\models\BonusGenerated;

/**
 * BonusController implements the CRUD actions for BonusSetting model.
 */
class BonusController extends Controller
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
        				'roles' => ['administrator'],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all BonusSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BonusSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BonusSetting model.
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
     * Creates a new BonusSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BonusSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BonusSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
    	$id = Yii::$app->request->get('id');
    	if ($id == null) {
    		$defaultProduct = MachineProduct::getDefaultProduct();
    		$model = BonusSetting::findOne(['product_id' => $defaultProduct->id]);
    	} else {
        	$model = $this->findModel($id);
    	}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	BonusHelper::generateBonus($model);
        	Yii::$app->session->setFlash('success', '更新提成信息成功');
//             return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BonusSetting model.
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
     * Finds the BonusSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BonusSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BonusSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSimulate()
    {
    	
    	
//     	BonusHelper::resetSimulateBonusData();
//     	$type = BonusHelper::SIMULATE_TYPE_SINGLE_FORK;
//     	$classPrefix = "backend\\models\\test\\";
//     	$orderClass = $classPrefix . "Order" . $type;
//     	$userClass = $classPrefix . "User" . $type;
//     	$userBonusClass = $classPrefix . "UserBonus" . $type;
//     	$bonusLogClass = $classPrefix . "BonusLog" . $type;
    	
//     	$orders = $orderClass::find()->asArray()->all();
//     	foreach ($orders as $order) {
//     		BonusHelper::triggerSimulateBonus($order, $type);
//     	}
//     	$totalIncoming = $bonusSetting->single_price * BonusHelper::MAX_LEVEL_USER_COUNT;
//     	$totalReturnBonus = $userBonusClass::find()->where(['product_id' => $defaultProductId])->sum('return_bonus');
//     	$totalSaleBonus = $userBonusClass::find()->where(['product_id' => $defaultProductId])->sum('sale_bonus');
//     	$totalManageBonus = $userBonusClass::find()->where(['product_id' => $defaultProductId])->sum('manage_bonus');
//     	$totalOutgoing = $userClass::find()->sum('total_bonus');
//     	$totalDiff = $totalIncoming - $totalOutgoing;
    	$defaultProductId = MachineProduct::getDefaultProduct()->id;
    	$bonusSetting = BonusSetting::findOne(['product_id' => $defaultProductId]);
    	$level = $bonusSetting->level_limit;
    	
    	$levelUserCount = 1;
    	$userTotal = 1;
    	$totalIncoming = 0;
    	$totalReturnBonus = 0;
    	$totalSaleBonus = 0;
    	$totalManageBonus = 0;
    	$totalOutgoing = 0;
    	$totalYearly = 0;
    	
    	$userAbove10 = 0;
    	$userBetween10to8 = 0;
    	$userBetween8to6 = 0;
    	
    	$userBelow10 = 2046;
    	$userBelow8 = 510;
    	$userBelow6 = 126;
    	for ($i = $level - 1; $i > 0; $i --) {
    		if ($i == 10) {
    			$userAbove10 = $levelUserCount;
    		} elseif ($i < 10 && $i >= 8) {
    			$userBetween10to8 += $levelUserCount;
    		} elseif ($i < 8 && $i >= 6) {
    			$userBetween8to6 += $levelUserCount;
    		}
    		
    		$totalSaleBonus += BonusGenerated::find()->where(['bonus_type' => BonusGenerated::TYPE_SALE_BONUS])->andWhere(['<=', 'sold_critical', $i])->sum('bonus_amount') * $levelUserCount;
    		$totalManageBonus += BonusGenerated::find()->where(['bonus_type' => BonusGenerated::TYPE_MANAGE_BONUS])->andWhere(['<=', 'sold_critical', $i])->sum('bonus_amount') * $levelUserCount;
    		$levelUserCount = $levelUserCount * 2;
    		$userTotal += $levelUserCount;
    	}
    	$yearlyUnit = $bonusSetting->single_price * $bonusSetting->yearly_bonus / 100;
    	$totalYearly = 1 * ($userTotal - 1) * $yearlyUnit
    				+ $userAbove10 * $userBelow10 * $yearlyUnit
    				+ $userBetween10to8 * $userBelow8 * $yearlyUnit
    				+ $userBetween8to6 * $userBelow6 * $yearlyUnit;
    	$totalReturnBonus = $userTotal * $bonusSetting->once_return;
    	$totalCost = $userTotal * $bonusSetting->single_cost;
    	$totalOutgoing = $totalManageBonus + $totalReturnBonus + $totalSaleBonus + $totalCost + $totalYearly;
    	$totalIncoming = $userTotal * $bonusSetting->single_price;
    	$totalDiff = $totalIncoming - $totalOutgoing;
    	
    	Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
    	return [
    		'totalIncoming' => $totalIncoming,
    		'totalReturnBonus' => $totalReturnBonus,
    		'totalSaleBonus' => $totalSaleBonus,
    		'totalManageBonus' => $totalManageBonus,
    		'totalYearly' => $totalYearly,
    		'totalOutgoing' => $totalOutgoing,
    		'totalDiff' => $totalDiff,
    		'totalCount' => $userTotal,
    		'totalCost' => $totalCost,
    	];
    }
}
