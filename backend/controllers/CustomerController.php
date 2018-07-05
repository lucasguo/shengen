<?php

namespace backend\controllers;

use Yii;
use backend\models\Customer;
use backend\models\OwnCustomerSearch;
use backend\models\AllCustomerSearch;
use backend\models\CustomerMaintainForm;
use backend\models\CustomerMaintain;
use backend\models\Alert;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use backend\models\UserRelation;
use backend\models\MachineProduct;
use common\models\User;
use yii\web\ServerErrorHttpException;
use yii\base\InvalidParamException;
use backend\models\MyCustomerForm;
use backend\models\OrderMaster;
use backend\models\BonusSetting;
use backend\helpers\BTreeNode;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
        				'actions' => ['view', 'index', 'maintain', 'create', 'my-team', 'my-money'],
        				'allow' => true,
        				'roles' => ['addCustomer'],
        			],
        			[
	        			'actions' => ['delete', 'update', 'all-index'],
	        			'allow' => true,
	        			'roles' => ['updateCustomer'],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all Customer models belong to current user.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OwnCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionMaintain($id)
    {
    	$customer = $this->findModel($id);
    	if($customer->belongto != Yii::$app->user->id)
    	{
    		throw new ForbiddenHttpException('无权操作该客户');
    	}
    	$customerName = $customer->customer_name;
    	$model = new CustomerMaintainForm();
    
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->validate()) {
    			$maintain = new CustomerMaintain();
    			$maintain->customer_id = $id;
    			$maintain->content = $model->content;
    			$maintain->save();
    			if($model->add_alert === '1')
    			{
    				$alert = new Alert();
    				$alertContent = "维护" . $customerName;
    				if(!empty($model->alert_content)) {
    					$alertContent .= " - " . $model->alert_content;
    				}
    				$alert->content = $alertContent;
    				$alert->alert_date = $model->alert_date;
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
    
    public function actionMyTeam()
    {
    	$rootId = Yii::$app->request->get("rootId");
    	
    	if ($rootId == null) {
    		$rootId = Yii::$app->user->id;
    	}
    	
    	$titleUsername = "我";
    	if ($rootId != Yii::$app->user->id) {
    		$titleUsername = User::findOne($rootId)->username;
    	}
    	
    	$this->checkTeamPermission($rootId);
    	$tree = $this->getCustomerTree($rootId, 5);
    	return $this->render("my-team", [
    		"tree" => $tree,
    		'titleUsername' => $titleUsername,
    	]);
    }
    
    protected function checkTeamPermission($rootId) {
    	$currentUserId = Yii::$app->user->id;
    	if ($rootId != $currentUserId) {
    		$found = false;
    		$relation = UserRelation::findOne(['user_id' => $rootId]);
    		if ($relation == null) {
    			throw new NotFoundHttpException("该成员不存在");
    		}
    		while ($relation != null) {
    			if ($relation->up_id == $currentUserId) {
    				$found = true;
    				break;
    			}
    			$relation = UserRelation::findOne(['user_id' => $relation->up_id]);
    		}
    		if (!$found) {
    			throw new ForbiddenHttpException("无权限查看该成员的团队图");
    		}
    	}
    }
    
    protected function getCustomerTree($rootId, $levelLimit) 
    {
    	$currentLevel = 1;
    	$rootNode = new BTreeNode();
    	$this->fillNode($rootId, $rootNode, $currentLevel, $levelLimit);
    	return $rootNode;
    }
    
    /**
     * 
     * @param integer $userId
     * @param BTreeNode $node
     * @param integer $currentLevel
     * @param integer $levelLimit
     */
    protected function fillNode($userId, &$node, $currentLevel, $levelLimit)
    {
    	if ($currentLevel > $levelLimit) {
    		return;
    	}
    	$user = User::findOne($userId);
    	if ($user != null && $user->customer_id != null) {
    		$customer = Customer::findOne($user->customer_id);
    		$node->item = $customer;
    		$node->key = $userId;
    	}
    	$relation = UserRelation::findOne(['user_id' => $userId]);
    	if ($relation != null) {
    		if ($relation->left_id != null) {
    			$node->leftNode = new BTreeNode();
    			$this->fillNode($relation->left_id, $node->leftNode, $currentLevel + 1, $levelLimit);
    		}
    		if ($relation->right_id != null) {
    			$node->rightNode = new BTreeNode();
    			$this->fillNode($relation->right_id, $node->rightNode, $currentLevel + 1, $levelLimit);
    		}
    	}
    }
    
    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionAllIndex()
    {
    	$searchModel = new AllCustomerSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('all-index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$count = Yii::$app->db->createCommand('
		    SELECT COUNT(*) FROM customer_maintain WHERE customer_id=:cid
		', [':cid' => $id])->queryScalar();
    	
    	$dataProvider = new SqlDataProvider([
    		'sql' => 'SELECT c.content, c.created_at, u.username FROM customer_maintain c left join user u on c.created_by=u.id WHERE c.customer_id=:cid',
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

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model->setScenario('new');

        if ($model->load(Yii::$app->request->post()) && $model->generateSn() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateMyCustomer()
    {
    	$model = new MyCustomerForm();
    	$side = Yii::$app->request->get("side");
    	$userId = Yii::$app->request->get('userId', null);
    	if ($userId == null) {
    		$userId = Yii::$app->user->id;
    	}
    	$this->checkTeamPermission($userId);
    	if ($side != UserRelation::USER_SIDE_LEFT && $side != UserRelation::USER_SIDE_RIGHT) {
    		throw new InvalidParamException("参数无效");
    	}
    	$productId = Yii::$app->request->post('productId', null);
    	if ($productId == null) {
    		$productId = MachineProduct::getDefaultProduct()->id;
    	}
    	
    	$relation = UserRelation::findOne(['user_id' => $userId, 'product_id' => $productId]);
    	if ($relation == null) {
    		$relation = new UserRelation();
    		$relation->user_id = $userId;
    		$relation->product_id = $productId;
    		$relation->save();
    	} else {
    		if (($side == UserRelation::USER_SIDE_LEFT && $relation->left_id != null) ||
    				$side == UserRelation::USER_SIDE_RIGHT && $relation->right_id != null) {
    			throw new InvalidParamException("无法在该位置添加顾客");
    		}
    	}
    	
    	
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		$txn = Yii::$app->db->beginTransaction();
    		try {
    			$customer = new Customer();
    			$customer->setScenario("new");
    			$customer->customer_mobile = $model->customer_mobile;
    			$customer->customer_name = $model->customer_name;
    			$customer->auto_convert = $model->auto_convert;
    			$customer->bankaccount = $model->bankaccount;
    			$customer->bankname = $model->bankname;
    			$customer->beneficiary = $model->beneficiary;
    			$customer->generateSn();
    			if (!$customer->save()) {
    				$errorStr = "";
    				foreach ($customer->getErrors() as $attribute => $errors) {
    					$errorStr .= "<" . $attribute . ">\n";
    					foreach ($errors as $error)
    					{
    						$errorStr .= "  " . $error . "\n";
    					}
    					$errorStr .= "\n";
    				}
    				throw new \Exception("顾客无法保存，原因：\n" . $errorStr);
    			}
    			
    			// create new user
    			$user = new User();
    			$user->customer_id = $customer->id;
    			$user->email = $model->customer_email;
    			$user->mobile = $model->customer_mobile;
    			$user->username = $model->customer_name;
    			$user->bankaccount = $model->bankaccount;
    			$user->bankname = $model->bankname;
    			$user->beneficiary = $model->beneficiary;
    			$user->generateAuthKey();
    			$user->password_hash = "";
    			if (!$user->save()) {
    				$errorStr = "";
    				foreach ($user->getErrors() as $attribute => $errors) {
    					$errorStr .= "<" . $attribute . ">\n";
    					foreach ($errors as $error)
    					{
    						$errorStr .= "  " . $error . "\n";
    					}
    					$errorStr .= "\n";
    				}
    				throw new \Exception("用户无法保存，原因：\n" . $errorStr);
    			}
    			// sms is sent only when the money is paid (order/confirm)
    			
    			$role = Yii::$app->authManager->getRole("salesman");
    			Yii::$app->authManager->assign($role, $user->id);
    			
    			// create new order
    			$setting = BonusSetting::findOne(['product_id' => $productId]);
    			$salePrice = $setting->single_price - $setting->once_return;
    			$order = new OrderMaster();
    			$order->customer_id = $customer->id;
    			$order->need_invoice = 0;
    			$order->sold_amount = $salePrice;
    			$order->sold_count = 1;
    			$order->sold_datetime = time();
    			$order->generateSn();
    			$order->product_id = $productId;
    			$order->warranty_in_month = 12;
    			if (!$order->save()) {
    				$errorStr = "";
    				foreach ($order->getErrors() as $attribute => $errors) {
    					$errorStr .= "<" . $attribute . ">\n";
    					foreach ($errors as $error)
    					{
    						$errorStr .= "  " . $error . "\n";
    					}
    					$errorStr .= "\n";
    				}
    				throw new \Exception("订单无法保存，原因：\n" . $errorStr);
    			}
    			
    			// update user relation
    			if ($side == UserRelation::USER_SIDE_LEFT) {
    				$relation->left_id = $user->id;
    				$relation->left_status = UserRelation::STATUS_NEW;
    				if (!$relation->save()) {
    					$errorStr = "";
    					foreach ($relation->getErrors() as $attribute => $errors) {
    						$errorStr .= "<" . $attribute . ">\n";
    						foreach ($errors as $error)
    						{
    							$errorStr .= "  " . $error . "\n";
    						}
    						$errorStr .= "\n";
    					}
    					throw new \Exception("从属关系无法保存，原因：\n" . $errorStr);
    				}
    			} elseif ($side == UserRelation::USER_SIDE_RIGHT) {
    				$relation->right_id = $user->id;
    				$relation->right_status = UserRelation::STATUS_NEW;
    				if (!$relation->save()) {
    					$errorStr = "";
    					foreach ($relation->getErrors() as $attribute => $errors) {
    						$errorStr .= "<" . $attribute . ">\n";
    						foreach ($errors as $error)
    						{
    							$errorStr .= "  " . $error . "\n";
    						}
    						$errorStr .= "\n";
    					}
    					throw new \Exception("从属关系无法保存，原因：\n" . $errorStr);
    				}
    			}
    			$newRelation = new UserRelation();
    			$newRelation->user_id = $user->id;
    			$newRelation->product_id = $productId;
    			$newRelation->up_id = $userId;
    			$newRelation->save();
    			$txn->commit();
    			return $this->redirect(['index', 'userId' => $userId]);
    		} catch(\Exception $e) {
    			$txn->rollBack();
    			Yii::error($e->getMessage());
    			throw new ServerErrorHttpException("无法保存该客户，请联系管理员");
    		}
    		
    	}
    	return $this->render('create-my-customer', [
    		'model' => $model,
    		'userId' => $userId,
    	]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionMyMoney()
    {
    	return $this->render('my-money');
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $customer = $this->findModel($id);
        $name = $customer->customer_name;
        if ($customer->delete()) {
        	Yii::$app->session->setFlash('success', '成功删除' . $name);
        } else {
        	Yii::$app->session->setFlash('error', '删除' . $name . '时发生错误，请联系管理员');
        }

        return $this->redirect(['all-index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
