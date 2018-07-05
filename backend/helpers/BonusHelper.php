<?php 
namespace backend\helpers;

use Yii;
use backend\models\BonusSetting;
use backend\models\BonusGenerated;
use common\models\User;
use backend\models\UserBonus;
use backend\models\UserRelation;
use backend\models\BonusLog;
use backend\models\OrderMaster;
use yii\helpers\ArrayHelper;
use backend\models\MachineProduct;
use backend\models\test\UserTest;
use backend\models\test\UserBonusTest;
use backend\models\test\UserRelationTest;

class BonusHelper
{
	const SIMULATE_TYPE_SINGLE = 'Single';
	const SIMULATE_TYPE_SINGLE_FORK = 'SingleFork';
	const SIMULATE_TYPE_DOUBLE_FORK = 'DoubleFork';
	const MAX_LEVEL_USER_COUNT = 1023;
	
	protected static $bonusArray;
	
	protected static function getBonusArray()
	{
		if(empty(static::$bonusArray)) {
			$bonuses = BonusGenerated::find()->asArray()->all();
			static::$bonusArray = ArrayHelper::index($bonuses, null, 'sold_critical');
		}
		return static::$bonusArray;
	}
	
	/**
	 * 
	 * @param BonusSetting $bonus
	 */
	public static function generateBonus($bonus)
	{
		$productId = $bonus->product_id;
		$levelLimit = $bonus->level_limit;
		$price = $bonus->single_price;
		$saleBonus = $bonus->sale_bonus;
		$manageBonus = $bonus->manage_bonus;
		$lastLevelCount = 1;
		$totalCount = 1;
		$lastLevelSaleBonus = 0;
		BonusGenerated::deleteAll(['product_id' => $productId]);
		for ( $i = 1; $i < $levelLimit; $i ++ ) {
			$currentLevelCount = $lastLevelCount * 2;
			$currentLevelSaleBonus = $currentLevelCount * $price * $saleBonus / 100;
			$totalCount += $currentLevelCount;
			$bonusGeneratedSale = new BonusGenerated();
			$bonusGeneratedSale->bonus_amount = $currentLevelSaleBonus;
			$bonusGeneratedSale->bonus_type = BonusGenerated::TYPE_SALE_BONUS;
			$bonusGeneratedSale->product_id = $productId;
// 			$bonusGeneratedSale->sold_critical = $totalCount;
			$bonusGeneratedSale->sold_critical = $i;
			$bonusGeneratedSale->save();
			if ( $lastLevelSaleBonus != 0 ) {
				$bonusGeneratedManage = new BonusGenerated();
				$bonusGeneratedManage->bonus_amount = $currentLevelSaleBonus * $manageBonus / 100;
				$bonusGeneratedManage->bonus_type = BonusGenerated::TYPE_MANAGE_BONUS;
				$bonusGeneratedManage->product_id = $productId;
// 				$bonusGeneratedManage->sold_critical = $totalCount;
				$bonusGeneratedManage->sold_critical = $i;
				$bonusGeneratedManage->save();
			}
			$lastLevelCount = $currentLevelCount;
			$lastLevelSaleBonus = $currentLevelSaleBonus;
		}
	}
	
	/**
	 * 
	 * @param OrderMaster $order
	 */
	public static function triggerBonus($order)
	{
// 		$bonusSetting = BonusSetting::findOne(['product_id' => $order->product_id]);
// 		$user = User::findOne(['customer_id' => $order->customer_id]);
// 		$userBonus = UserBonus::findOne(['user_id' => $user->id, 'product_id' => $order->product_id]);
// 		if ($userBonus == null) {
// 			$userBonus = new UserBonus();
// 			$userBonus->manage_bonus = 0;
// 			$userBonus->return_bonus = 0;
// 			$userBonus->sale_bonus = 0;
// 			$userBonus->sold_count = 0;
// 			$userBonus->total_bonus = 0;
// 			$userBonus->user_id = $user->id;
// 			$userBonus->product_id = $order->product_id;
// 			$userBonus->save();
// 		}
// 		$userBonus->return_bonus += $bonusSetting->once_return;
// 		$userBonus->sold_count ++;
// 		$returnLog = new BonusLog();
// 		$returnLog->bonus_amount = $bonusSetting->once_return;
// 		$returnLog->bonus_date = date('Y-m-d');
// 		$returnLog->bonus_type = BonusGenerated::TYPE_ONCE_RETURN;
// 		$returnLog->order_id = $order->id;
// 		$returnLog->product_id = $order->product_id;
// 		$returnLog->sold_critical = 1;
// 		$returnLog->user_id = $user->id;
// 		$returnLog->save();
		
// 		$rules = BonusGenerated::findAll(['sold_critical' => $userBonus->sold_count]);
// 		foreach ($rules as $rule) {
// 			if ($rule->bonus_type == BonusGenerated::TYPE_SALE_BONUS) {
// 				$userBonus->sale_bonus += $rule->bonus_amount;
// 			}
// 			if ($rule->bonus_type == BonusGenerated::TYPE_MANAGE_BONUS) {
// 				$userBonus->manage_bonus += $rule->bonus_amount;
// 			}
// 			$log = new BonusLog();
// 			$log->bonus_amount = $rule->bonus_amount;
// 			$log->bonus_date = date('Y-m-d');
// 			$log->bonus_type = $rule->bonus_type;
// 			$log->order_id = $order->id;
// 			$log->product_id = $order->product_id;
// 			$log->sold_critical = $rule->sold_critical;
// 			$log->user_id = $user->id;
// 			$log->save();
// 		}
// 		$userBonus->save();
		
// 		$upid = $user->up_id;
// 		while ($upid != null) {
// 			$upUser = User::findOne($upid);
// 			$upUserBonus = UserBonus::findOne(['user_id' => $upid, 'product_id' => $order->product_id]);
// 			$upUserBonus->sold_count ++;
			
// 			$rules = BonusGenerated::findAll(['sold_critical' => $upUserBonus->sold_count]);
// 			foreach ($rules as $rule) {
// 				if ($rule->bonus_type == BonusGenerated::TYPE_SALE_BONUS) {
// 					$upUserBonus->sale_bonus += $rule->bonus_amount;
// 				}
// 				if ($rule->bonus_type == BonusGenerated::TYPE_MANAGE_BONUS) {
// 					$upUserBonus->manage_bonus += $rule->bonus_amount;
// 				}
// 				$log = new BonusLog();
// 				$log->bonus_amount = $rule->bonus_amount;
// 				$log->bonus_date = date('Y-m-d');
// 				$log->bonus_type = $rule->bonus_type;
// 				$log->order_id = $order->id;
// 				$log->product_id = $order->product_id;
// 				$log->sold_critical = $rule->sold_critical;
// 				$log->user_id = $upUser->id;
// 				$log->save();
// 			}
// 			$upUserBonus->save();
// 			$upid = $upUser->up_id;
// 		}

		$bonusSetting = BonusSetting::findOne(['product_id' => $order->product_id]);
		$user = User::findOne(['customer_id' => $order->customer_id]);
		// UserBonus is created at the time of customer transfer to user
		$currentUserBonus = UserBonus::findOne(['user_id' => $user->id, 'product_id' => $order->product_id]);
		if ($order->created_by == $user->id) {
			$upid = $user->id;
		} else {
			$upid = $userBonus->up_id;
		}
		if ($upid != null) {
			$userBonus = UserBonus::findOne(['user_id' => $upid, 'product_id' => $order->product_id]);
			$userBonus->return_bonus += $bonusSetting->once_return;
			$userBonus->save();
			$upReturnUser = User::findOne($upid);
			$upReturnUser->total_bonus += $bonusSetting->once_return * $order->sold_count;
			$upReturnUser->available_bonus += $bonusSetting->once_return * $order->sold_count;
			$upReturnUser->save();
			$returnLog = new BonusLog();
			$returnLog->bonus_amount = $bonusSetting->once_return;
			$returnLog->bonus_date = date('Y-m-d');
			$returnLog->bonus_type = BonusGenerated::TYPE_ONCE_RETURN;
			$returnLog->order_id = $order->id;
			$returnLog->product_id = $order->product_id;
			$returnLog->sold_critical = 1;
			$returnLog->user_id = $upid;
			$returnLog->save();
		}
		
		while ($upid != null) {
			$upUser = User::findOne($upid);
			$upUserBonus = UserBonus::findOne(['user_id' => $upid, 'product_id' => $order->product_id]);
			if ($upUserBonus == null) {
				break;
			}
			for ($i = 1; $i <= $order->sold_count; $i++) {
				$upUserBonus->sold_count ++;
		
				$rules = BonusGenerated::findAll(['sold_critical' => $upUserBonus->sold_count]);
				foreach ($rules as $rule) {
					if ($rule->bonus_type == BonusGenerated::TYPE_SALE_BONUS) {
						$upUserBonus->sale_bonus += $rule->bonus_amount;
					}
					if ($rule->bonus_type == BonusGenerated::TYPE_MANAGE_BONUS) {
						$upUserBonus->manage_bonus += $rule->bonus_amount;
					}
					$log = new BonusLog();
					$log->bonus_amount = $rule->bonus_amount;
					$log->bonus_date = date('Y-m-d');
					$log->bonus_type = $rule->bonus_type;
					$log->order_id = $order->id;
					$log->product_id = $order->product_id;
					$log->sold_critical = $rule->sold_critical;
					$log->user_id = $upUser->id;
					$log->save();
				}
				
			}
			$upUserBonus->save();
			$upid = $upUserBonus->up_id;
		}
	}
	
	public static function resetSimulateBonusData()
	{
		$types = [static::SIMULATE_TYPE_SINGLE, static::SIMULATE_TYPE_SINGLE_FORK, static::SIMULATE_TYPE_DOUBLE_FORK];
		foreach ($types as $type) {
			$classPrefix = "backend\\models\\test\\";
			$userClass = $classPrefix . "User" . $type;
			$userBonusClass = $classPrefix . "UserBonus" . $type;
			$bonusLogClass = $classPrefix . "BonusLog" . $type;
			$userClass::updateAll(['total_bonus' => 0, 'available_bonus' => 0]);
			$userBonusClass::updateAll([
				'return_bonus' => 0,
				'sale_bonus' => 0,
				'manage_bonus' => 0,
				'sold_count' => 0,
			]);
			Yii::$app->getDb()->createCommand('truncate table ' . $bonusLogClass::tableName())->execute();
		}
	}
	
	public static function triggerSimulateBonus($order, $type)
	{
		$classPrefix = "backend\\models\\test\\";
		$userClass = $classPrefix . "User" . $type;
		$userBonusClass = $classPrefix . "UserBonus" . $type;
		$bonusLogClass = $classPrefix . "BonusLog" . $type;
		$bonusSetting = BonusSetting::findOne(['product_id' => $order['product_id']]);
		$user = $userClass::findOne(['customer_id' => $order['customer_id']]);
		// UserBonus is created at the time of customer transfer to user
		$currentUserBonus = $userBonusClass::findOne(['user_id' => $user->id, 'product_id' => $order['product_id']]);
		if ($order['created_by'] == $user->id) {
			$upid = $user->id;
		} else {
			$upid = $currentUserBonus->up_id;
		}
		if ($upid != null) {
			$userBonus = $userBonusClass::findOne(['user_id' => $upid, 'product_id' => $order['product_id']]);
			$userBonus->return_bonus += $bonusSetting->once_return;
			$userBonus->save();
			$upReturnUser = $userClass::findOne($upid);
			$upReturnUser->total_bonus += $bonusSetting->once_return * $order['sold_count'];
			$upReturnUser->available_bonus += $bonusSetting->once_return * $order['sold_count'];
			$upReturnUser->save(false);
			unset($upReturnUser);
			$returnLog = new $bonusLogClass();
			$returnLog->bonus_amount = $bonusSetting->once_return;
			$returnLog->bonus_date = date('Y-m-d');
			$returnLog->bonus_type = BonusGenerated::TYPE_ONCE_RETURN;
			$returnLog->order_id = $order['id'];
			$returnLog->product_id = $order['product_id'];
			$returnLog->sold_critical = 1;
			$returnLog->user_id = $upid;
			$returnLog->save(false);
			unset($returnLog);
		}
		
		while ($upid != null) {
			$upUser = $userClass::findOne($upid);
			$upUserBonus = $userBonusClass::findOne(['user_id' => $upid, 'product_id' => $order['product_id']]);
			if ($upUserBonus == null) {
				break;
			}
			for ($i = 1; $i <= $order['sold_count']; $i++) {
				$upUserBonus->sold_count ++;
		
				$bonusArray = static::getBonusArray();
				if (array_key_exists($upUserBonus->sold_count, $bonusArray)) {
					$rules = $bonusArray[$upUserBonus->sold_count];
				
					foreach ($rules as $rule) {
						if ($rule['bonus_type'] == BonusGenerated::TYPE_SALE_BONUS) {
							$upUserBonus->sale_bonus += $rule['bonus_amount'];
						}
						if ($rule['bonus_type'] == BonusGenerated::TYPE_MANAGE_BONUS) {
							$upUserBonus->manage_bonus += $rule['bonus_amount'];
						}
						$log = new $bonusLogClass();
						$log->bonus_amount = $rule['bonus_amount'];
						$log->bonus_date = date('Y-m-d');
						$log->bonus_type = $rule['bonus_type'];
						$log->order_id = $order['id'];
						$log->product_id = $order['product_id'];
						$log->sold_critical = $upUserBonus->sold_count;
						$log->user_id = $upUser->id;
						$log->save(false);
						$upUser->total_bonus += $rule['bonus_amount'];
						$upUser->available_bonus += $rule['bonus_amount'];
						unset($log);
					}
					$upUser->save(false);
				}
		
			}
			$upUserBonus->save(false);
			$upid = $upUserBonus->up_id;
		}
	}
	
	public static function calcBonus($isTest = false)
	{
		if ($isTest) {
			$userIds = [];
			$users = UserTest::find()->select('id')->asArray()->all();
			foreach ($users as $user) {
				$userIds[] = $user['id'];
			}
		} else {
			$authManager = Yii::$app->authManager;
			$dealerIds = $authManager->getUserIdsByRole('dealer');
			$salesIds = $authManager->getUserIdsByRole('salesman');
			$userIds = array_unique(array_merge($dealerIds, $salesIds));	
		}
		$productId = MachineProduct::getDefaultProduct()->id;
		$setting = BonusSetting::findOne(['product_id' => $productId]);
		$bonusClass = UserBonus::className();
		if ($isTest) {
			$bonusClass = UserBonusTest::className();
		}
		$userClass = User::className();
		if ($isTest) {
			$userClass = UserTest::className();
		}
		foreach ($userIds as $userId) {
			$user = $userClass::findOne($userId);
			$userBonus = $bonusClass::findOne(['product_id' => $productId, 'user_id' => $userId]);
			if ($userBonus == null) {
				$userBonus = new $bonusClass();
				$userBonus->user_id = $userId;
				$userBonus->product_id = $productId;
				$userBonus->return_bonus = 0;
				$userBonus->sale_bonus = 0;
				$userBonus->manage_bonus = 0;
				$userBonus->user_level = 0;
				$userBonus->save();
			}
			$level = static::calcUserLevel($userId, $productId, $setting->level_limit, $isTest);
			\Yii::trace("user " . $user->username . "'s level is $level\n");
			if ($level > $userBonus->user_level) {
				$saleBonus = BonusGenerated::find()
				->where(['bonus_type' => BonusGenerated::TYPE_SALE_BONUS])
				->andWhere(['>', 'sold_critical', $userBonus->user_level])
				->andWhere(['<=', 'sold_critical', $level])
				->sum('bonus_amount');
				// 				echo "sale bonus sum is $saleBonus\n";
				$manageBonus = BonusGenerated::find()
				->where(['bonus_type' => BonusGenerated::TYPE_MANAGE_BONUS])
				->andWhere(['>', 'sold_critical', $userBonus->user_level])
				->andWhere(['<=', 'sold_critical', $level])
				->sum('bonus_amount');
				// 				echo "manage bonus sum is $saleBonus\n";
				$userBonus->sale_bonus += $saleBonus;
				$userBonus->manage_bonus += $manageBonus;
				$userBonus->user_level = $level;
				$userBonus->save();
				$incoming = $saleBonus + $manageBonus;
				$user->available_bonus += $incoming;
				$user->total_bonus += $incoming;
				$user->save();
			}
		}
	}
	
	protected static function calcUserLevel($userId, $productId, $levelLimit, $isTest)
	{
		$userIds = [$userId];
		for ($i = 0; $i < $levelLimit; $i ++) {
			$userIds = static::checkCompelete($userIds, $isTest);
			if ($userIds == null) {
				break;
			}
		}
		return $i;
	}
	
	/**
	 * if this level is complete, return all sub level user ids, else return null.
	 * @param array $userIds
	 * @return array|null
	 */
	protected static function checkCompelete($userIds, $isTest) {
		$relationClass = UserRelation::className();
		if ($isTest) {
			$relationClass = UserRelationTest::className();
		}
		$relations = $relationClass::find()->where(['in', 'user_id', $userIds])
		->andWhere(['left_status' => UserRelation::STATUS_CONFIRMED])
		->andWhere(['right_status' => UserRelation::STATUS_CONFIRMED])->asArray()->all();
		if ($relations == null || count($userIds) != count($relations)) {
			return null;
		} else {
			$ids = [];
			foreach ($relations as $relation) {
				$ids[] = $relation['left_id'];
				$ids[] = $relation['right_id'];
			}
			return $ids;
		}
	}
}
