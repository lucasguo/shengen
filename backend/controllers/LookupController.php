<?php
namespace backend\controllers;

use backend\models\DealerShopSearch;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\PartTypeSearch;
use common\models\UserSearch;
use backend\models\AllCustomerSearch;
use backend\models\MachineMasterSearch;
use backend\models\MachineMaster;

class LookupController extends Controller
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
						'actions' => ['part-type'],
						'allow' => true,
						'roles' => ['manageProduct'],
					],
					[
						'actions' => ['all-salesman'],
						'allow' => true,
						'roles' => ['updateCustomer', 'maintainDealerShop'],
					],
                    [
                        'actions' => ['all-shop'],
                        'allow' => true,
                        'roles' => ['manageUser', 'maintainDealerShop'],
                    ],
					[
						'actions' => ['all-customer'],
						'allow' => true,
						'roles' => ['addOrder', 'updateOrder'],
					],
					[
						'actions' => ['machine-in-house'],
						'allow' => true,
						'roles' => ['manageMachine'],
					],
				],
			],
		];
	}
	
	public function actionPartType($modalId)
	{
		$callback = Yii::$app->request->get("jsCallback");
		$searchModel = new PartTypeSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->renderAjax('part-type', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'modalId' => $modalId,
			'callback' => $callback,
		]);
	}
	
	public function actionAllSalesman($modalId)
	{
		$callback = Yii::$app->request->get("jsCallback");
		$searchModel = new UserSearch();
		$params = Yii::$app->request->queryParams;
		$params['UserSearch']['userIds'] = Yii::$app->authManager->getUserIdsByRole('salesman');
		$dataProvider = $searchModel->search($params);
	
		return $this->renderAjax('all-salesman', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'modalId' => $modalId,
			'callback' => $callback,
		]);
	}
	
	public function actionAllCustomer($modalId)
	{
		$callback = Yii::$app->request->get("jsCallback");
		$searchModel = new AllCustomerSearch();
		$params = Yii::$app->request->queryParams;
		$dataProvider = $searchModel->search($params);
	
		return $this->renderAjax('all-customer', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'modalId' => $modalId,
			'callback' => $callback,
		]);
	}

    public function actionAllShop($modalId)
    {
        $callback = Yii::$app->request->get("jsCallback");
        $searchModel = new DealerShopSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->renderAjax('all-shop', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modalId' => $modalId,
            'callback' => $callback,
        ]);
    }
	
	public function actionMachineInHouse($modalId)
	{
		$callback = Yii::$app->request->get("jsCallback");
		$searchModel = new MachineMasterSearch();
		$params = Yii::$app->request->queryParams;
		$searchModel->machine_status = MachineMaster::STATUS_WAREHOUSED;
		$dataProvider = $searchModel->search($params);
	
		return $this->renderAjax('machine-in-house', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'modalId' => $modalId,
			'callback' => $callback,
		]);
	}
}