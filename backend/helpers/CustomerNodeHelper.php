<?php
namespace backend\helpers;

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use backend\models\Customer;
use backend\models\UserRelation;
use backend\models\test\UserTest;
use backend\models\test\UserRelationTest;

class CustomerNodeHelper
{
	/**
	 * 
	 * @param BTreeNode $node
	 * @param string $id
	 */
	public static function renderNode($node, $isTest=false)
	{
		if ($node->item == null && $node->leftNode == null && $node->rightNode == null) {
			return;
		}

		$class = "bg-gray";
		$content = "总监";
		if ($node->item != null) {
			if ($isTest) {
				$content = $node->item->username;
				$content .= '<br>' . $node->item->total_bonus;
				$class = "bg-yellow";
			} else {
				$content = $node->item->customer_name;
				if ($node->item->customer_status == Customer::STATUS_ACTIVE) {
					$class = "bg-yellow";
				} else {
					$class = "bg-green";
				}
			}
		}
		$isLink = false;
		if ($node->key != null) {
			$isLink = true;
			if ($isTest) {
				$link = Url::to(['test/show-team', 'rootId' => $node->key]);
			} else {
				$link = Url::to(['customer/my-team', 'rootId' => $node->key]);
			}
		}
		echo "<li class='$class'>";
		if ($isLink) {
			echo Html::a($content, $link);
		} else {
			echo $content;
		}
		
		$editUrl = Url::to(['customer/index', 'userId' => $node->key]);
		$dropdown = <<<HTML
<div class="dropdown">
    <button type="button" class="btn dropdown-toggle" id="dropdownMenu$key" data-toggle="dropdown">操作
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu$key">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="$editUrl">编辑下属客户</a>
        </li>
    </ul>
</div>
HTML;
		echo $dropdown;
		
		echo Html::beginTag("ul");
		if ($node->leftNode != null) {
			static::renderNode($node->leftNode, $isTest);
		}
		if ($node->rightNode != null) {
			static::renderNode($node->rightNode, $isTest);
		}
		echo Html::endTag("ul");
		
		echo "</li>";
		
		
	}
	
	public static function getCustomerTree($rootId, $levelLimit, $isTest=false)
	{
		$currentLevel = 1;
		$rootNode = new BTreeNode();
		static::fillNode($rootId, $rootNode, $currentLevel, $levelLimit, $isTest);
		return $rootNode;
	}
	
	/**
	 *
	 * @param integer $userId
	 * @param BTreeNode $node
	 * @param integer $currentLevel
	 * @param integer $levelLimit
	 */
	protected static function fillNode($userId, &$node, $currentLevel, $levelLimit, $isTest)
	{
		
		if ($currentLevel > $levelLimit) {
			return;
		}
		$userClass = User::className();
		if ($isTest) {
			$userClass = UserTest::className();
		}
		$user = $userClass::findOne($userId);
		if ($user != null) {
			if ($isTest) {
				$node->item = $user;
				$node->key = $userId;
			} else {
				if($user->customer_id != null) {
					$customer = Customer::findOne($user->customer_id);
					$node->item = $customer;
					$node->key = $userId;
				}
			}
		}
		$relationClass = UserRelation::className();
		if ($isTest) {
			$relationClass = UserRelationTest::className();
		}
		$relation = $relationClass::findOne(['user_id' => $userId]);
		if ($relation != null) {
			if ($relation->left_id != null) {
				$node->leftNode = new BTreeNode();
				static::fillNode($relation->left_id, $node->leftNode, $currentLevel + 1, $levelLimit, $isTest);
			}
			if ($relation->right_id != null) {
				$node->rightNode = new BTreeNode();
				static::fillNode($relation->right_id, $node->rightNode, $currentLevel + 1, $levelLimit, $isTest);
			}
		}
	}
}