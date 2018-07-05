<?php

namespace backend\modules\finance\controllers;

use backend\models\FinanceNew;
use Yii;
use backend\models\Finance;
use backend\models\FinanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\finance\models\ChartForm;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for Finance model.
 */
class DefaultController extends Controller
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
	        			'actions' => ['index', 'create', 'update', 'delete', 'view'],
	        			'allow' => true,
	        			'roles' => ['addFinance', 'updateFinance'],
        			],
        			[
        				'actions' => ['chart', 'chart'],
        				'allow' => true,
        				'roles' => ['viewFinance'],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all Finance models.
     * @return mixed
     */
    public function actionIndex($isNew = false)
    {
        $searchModel = new FinanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $isNew);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isNew' => $isNew,
        ]);
    }

    /**
     * Displays a single Finance model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $isNew)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $isNew),
            'isNew' => $isNew,
        ]);
    }

    /**
     * Creates a new Finance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type, $isNew)
    {
        if ($isNew) {
            $model = new FinanceNew();
        } else {
            $model = new Finance();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	if($model->type > 0) {
        		$model->amount = abs($model->amount);
        	} else {
        		$model->amount = -abs($model->amount);
        	}
        	$model->save();
            return $this->redirect(['view', 'id' => $model->id, 'isNew' => $isNew]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'type' => $type,
                'isNew' => $isNew,
            ]);
        }
    }

    /**
     * Updates an existing Finance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $isNew)
    {
        $model = $this->findModel($id, $isNew);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'isNew' => $isNew]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'isNew' => $isNew,
            ]);
        }
    }

    /**
     * Deletes an existing Finance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $isNew)
    {
        $this->findModel($id, $isNew)->delete();

        return $this->redirect(['index', 'isNew' => $isNew]);
    }
    
    public function actionChart($isNew = false)
    {
        if ($isNew) {
            $totalIncoming = Yii::$app->db->createCommand('
		    SELECT SUM(amount) FROM finance_new WHERE amount > 0
		')->queryScalar();
            if (empty($totalIncoming)) $totalIncoming = 0;

            $totalOutgoing = Yii::$app->db->createCommand('
		    SELECT SUM(amount) FROM finance_new WHERE amount < 0
		')->queryScalar();
            if (empty($totalOutgoing)) $totalOutgoing = 0;

            $totalFinance = $totalIncoming + $totalOutgoing;

            return $this->render('chart', [
                'totalIncoming' => $totalIncoming,
                'totalOutgoing' => $totalOutgoing,
                'totalFinance' => $totalFinance,
                'isNew' => $isNew,
            ]);

        } else {
            $totalIncoming = Yii::$app->db->createCommand('
		    SELECT SUM(amount) FROM finance WHERE amount > 0
		')->queryScalar();
            if (empty($totalIncoming)) $totalIncoming = 0;

            $totalOutgoing = Yii::$app->db->createCommand('
		    SELECT SUM(amount) FROM finance WHERE amount < 0
		')->queryScalar();
            if (empty($totalOutgoing)) $totalOutgoing = 0;

            $totalFinance = $totalIncoming + $totalOutgoing;

            $yearList = [];
            $currentYear = date("Y");
            $last5Year = $currentYear - 5;
            for ($i = $last5Year; $i <= $currentYear; $i++) {
                $yearList[$i] = $i . '年';
            }
            $monthList = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthList[$i] = $i . '月';
            }

            $form = new ChartForm();
            $form->load(Yii::$app->request->post());
            $form->validate();
            if ($form->search_type === 'year') {
                switch ($form->year_type) {
                    case "current":
                        $year = $currentYear;
                        $month = date("m");
                        break;
                    case "last":
                        $year = $currentYear - 1;
                        $month = 12;
                        break;
                    case "custom":
                        if ($form->year == $currentYear) {
                            $year = $currentYear;
                            $month = date("m");
                        } else {
                            $year = $form->year;
                            $month = 12;
                        }
                        break;
                }
                $type = 'year';
                $datas = Yii::$app->db->createCommand('CALL showFinanceChart(:year, :month, :maxnum, :type)')
                    ->bindParam(':year', $year)
                    ->bindParam(':month', $month)
                    ->bindParam(':maxnum', $month)
                    ->bindParam(':type', $type)->queryAll();
            } elseif ($form->search_type === 'month') {
                switch ($form->month_type) {
                    case "current":
                        $year = $currentYear;
                        $month = date("m");
                        $day = date("d");
                        break;
                    case "last":
                        $lastMonthTime = strtotime("last day of last month");
                        $year = date("Y", $lastMonthTime);
                        $month = date("m", $lastMonthTime);
                        $day = date("d", $lastMonthTime);
                        break;
                    case "custom":
                        if ($form->year == $currentYear && $form->month == date("m")) {
                            $year = $currentYear;
                            $month = date("m");
                            $day = date("d");
                        } else {
                            $year = $form->year;
                            $month = $form->month;
                            $day = date("d", strtotime("last day of " . $year . "-" . $month));
                        }
                        break;
                }
                $type = "month";
                $datas = Yii::$app->db->createCommand('CALL showFinanceChart(:year, :month, :maxnum, :type)')
                    ->bindParam(':year', $year)
                    ->bindParam(':month', $month)
                    ->bindParam(':maxnum', $day)
                    ->bindParam(':type', $type)->queryAll();
            }
            $incomingData = ArrayHelper::getColumn($datas, 'incoming');
            for ($i = 0; $i < count($incomingData); $i++) {
                $incomingData[$i] = floatval($incomingData[$i]);
            }
            $outgoingData = ArrayHelper::getColumn($datas, 'outgoing');
            for ($i = 0; $i < count($outgoingData); $i++) {
                $outgoingData[$i] = floatval($outgoingData[$i]);
            }
            $financeData = ArrayHelper::getColumn($datas, 'finance');
            for ($i = 0; $i < count($financeData); $i++) {
                $financeData[$i] = floatval($financeData[$i]);
            }

            return $this->render('chart', [
                'model' => $form,
                'monthList' => $monthList,
                'yearList' => $yearList,
                'totalIncoming' => $totalIncoming,
                'totalOutgoing' => $totalOutgoing,
                'totalFinance' => $totalFinance,
                'xAxisLabels' => ArrayHelper::getColumn($datas, 'occur_date'),
                'incomingData' => $incomingData,
                'outgoingData' => $outgoingData,
                'financeData' => $financeData,
                'isNew' => $isNew,
            ]);
        }
    }

    /**
     * Finds the Finance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Finance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $isNew)
    {
        if ($isNew) {
            $model = FinanceNew::findOne($id);
        } else {
            $model = Finance::findOne($id);
        }
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
