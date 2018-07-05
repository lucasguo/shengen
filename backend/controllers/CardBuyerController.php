<?php

namespace backend\controllers;

use backend\models\Card;
use backend\models\CardType;
use backend\models\CardUsage;
use backend\models\CollectCardBuyerForm;
use Yii;
use backend\models\CardBuyer;
use backend\models\CardBuyerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AddCardForm;
use backend\models\CardBuyerInfoSearch;
use yii\base\InvalidValueException;
use backend\models\CardUsageSearch;

/**
 * CardBuyerController implements the CRUD actions for CardBuyer model.
 */
class CardBuyerController extends Controller
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
                        'roles' => ['addCardBuyer'],
                    ],
                    [
                        'actions' => ['add-usage', 'index', 'add-card'],
                        'allow' => true,
                        'roles' => ['addCardUsage'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['addCardUsage', 'viewAllCardBuyer'],
                    ],
                    [
                        'actions' => ['update', 'delete', 'all-index'],
                        'allow' => true,
                        'roles' => ['viewAllCardBuyer'],
                    ],
                    [
                        'actions' => ['info'],
                        'allow' => true,
                        'roles' => ['viewOwnCardBuyer'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all CardBuyer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $searchModel = new CardBuyerSearch();
        $searchModel->shop_id = $shopId;
        $dataProvider = $searchModel->searchList(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInfo()
    {
        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $searchModel = new CardBuyerInfoSearch();
        $data = $searchModel->searchInfo($shopId);

        return $this->render('shop-info', [
            'data' => $data,
        ]);
    }

    public function actionAllIndex()
    {
        $searchModel = new CardBuyerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CardBuyer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $buyer = $this->findModel($id);
        if (!Yii::$app->user->can('viewAllCardBuyer')) {
            $shopId = Yii::$app->user->identity->shop_id;
            if (empty($shopId)) {
                throw new ForbiddenHttpException('The requested page does not exist.');
            }
            if ($buyer->shop_id != $shopId) {
                throw new ForbiddenHttpException('The requested page does not exist.');
            }
        }
     	$searchModel = new CardUsageSearch();
     	$searchModel->buyer_id = $id;
     	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $buyer,
        	'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new CardBuyer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CollectCardBuyerForm();

        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $model->shop_id = $shopId;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $txn = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $card = new Card();
                    $card->buyer_id = $model->id;
                    $card->card_no = $model->cardNo;
                    $duplicateCard = Card::findOne(['shop_id' => $shopId, 'card_no' => $model->cardNo]);
                    if ($duplicateCard != null) {
                        $card->card_no = Card::generateCardNo($shopId);
                        Yii::$app->session->addFlash('warning', '输入的卡号已存在，已自动帮您生成新卡号' . $card->card_no);
                    }
                    $card->card_type = $model->cardType;
                    $cardType = CardType::findOne($model->cardType);
                    $card->left_times = $cardType->times;
                    $card->shop_id = $shopId;
                    if ($card->save()) {
                        $txn->commit();
                        Yii::$app->session->addFlash('success', '成功添加顾客' . $model->buyername );
                        return $this->redirect(['index']);
                    } else {
                    	throw new InvalidValueException('未能保存理疗卡，请联系管理员。');
                    }
                } else {
                	throw new InvalidValueException('未能保存客户，请联系管理员。');
                }
            } catch (\Exception $e) {
                $txn->rollBack();
                Yii::$app->session->addFlash('error', '保存顾客出错，请联系管理员。');
            }

        }
        $model->cardNo = Card::generateCardNo($shopId);
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new CardUsage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddUsage($buyerId)
    {
        $shopId = Yii::$app->user->identity->shop_id;
        if (empty($shopId)) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $buyer = $this->findModel($buyerId);
        if ($buyer->shop_id != $shopId) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        $availableCount = Card::find()->where(['buyer_id' => $buyerId])->sum('left_times');
        if ($availableCount <= 0) {
        	Yii::$app->session->setFlash('error', '理疗卡次数已用完，需要办理新卡。');
        	return $this->redirect(['add-card', 'id' => $buyerId]);
        }
        $model = new CardUsage();
        $model->buyer_id = $buyerId;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//        	$model->use_datetime = time();
        	$txn = Yii::$app->db->beginTransaction();
        	try {
	        	if ($model->save()) {
	        		$card = Card::findOne($model->card_id);
	        		if ($card == null) {
	        			throw new InvalidValueException('无效的理疗卡');
	        		}
	        		$card->updateCounters(['left_times' => -1]);
	        		$txn->commit();
	        		Yii::$app->session->setFlash('success', '成功添加理疗记录');
	        		return $this->redirect(['index']);
	        	} else {
	        		throw new InvalidValueException('未能保存理疗记录，请联系管理员。');
	        	}
        	} catch(\Exception $e) {
        		$txn->rollBack();
        		Yii::$app->session->setFlash('error', $e->getMessage());
        	}
            
        }
        return $this->render('/card-usage/create', [
            'buyerId' => $buyerId,
            'model' => $model,
        ]);
    }
    
    public function actionAddCard($id)
    {
    	$model = new AddCardForm();
    	
    	$shopId = Yii::$app->user->identity->shop_id;
    	if (empty($shopId)) {
    		throw new ForbiddenHttpException('The requested page does not exist.');
    	}
    	$buyer = $this->findModel($id);
    	if ($buyer->shop_id != $shopId) {
    		throw new ForbiddenHttpException('The requested page does not exist.');
    	}
//     	$model->shop_id = $shopId;
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		$card = new Card();
    		$card->buyer_id = $id;
    		$card->card_no = $model->cardNo;
    		$card->card_type = $model->cardType;
    		$cardType = CardType::findOne($model->cardType);
    		$card->left_times = $cardType->times;
    		$card->shop_id = $shopId;
    		if ($card->save()) {
    			Yii::$app->session->setFlash('success', '成功为顾客' . $buyer->buyername . '办理新卡');
    			return $this->redirect(['index']);
    		}
    	}
    	$model->cardNo = Card::generateCardNo($shopId);
    	return $this->render('add-card', [
    		'buyername' => $buyer->buyername,
    		'model' => $model,
    	]);
    }

    /**
     * Updates an existing CardBuyer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', '成功更新顾客' . $model->buyername );
            return $this->redirect(['all-index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CardBuyer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['all-index']);
    }

    /**
     * Finds the CardBuyer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CardBuyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CardBuyer::find()->where(['id' => $id])->with('symptomDetail')->with('creator')->with('cards')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
