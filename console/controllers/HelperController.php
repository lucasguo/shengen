<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class HelperController extends Controller
{
	/**
	 * Clean all data from database except RBAC relate data
	 */
	public function actionCleanData()
	{
		if($this->confirm("Are you sure to clean all data?")) {
			Yii::$app->db->createCommand()->truncateTable('alert')->execute();
			
			Yii::$app->db->createCommand()->dropForeignKey('customer_customer_maintain', 'customer_maintain')->execute();
			Yii::$app->db->createCommand()->truncateTable('customer')->execute();
			Yii::$app->db->createCommand()->truncateTable('customer_maintain')->execute();
			Yii::$app->db->createCommand()->addForeignKey('customer_customer_maintain', 'customer_maintain', 'customer_id', 'customer', 'id', 'CASCADE')->execute();
			
			Yii::$app->db->createCommand()->truncateTable('machine')->execute();
			Yii::$app->db->createCommand()->truncateTable('machine_part')->execute();
			Yii::$app->db->createCommand()->truncateTable('machine_product')->execute();

			Yii::$app->db->createCommand()->dropForeignKey('order_master_detail', 'order_detail')->execute();
			Yii::$app->db->createCommand()->truncateTable('order_master')->execute();
			Yii::$app->db->createCommand()->truncateTable('order_detail')->execute();
			Yii::$app->db->createCommand()->addForeignKey('order_master_detail', 'order_detail', 'master_id', 'order_master', 'id', 'CASCADE')->execute();

			Yii::$app->db->createCommand()->truncateTable('part')->execute();
			Yii::$app->db->createCommand()->truncateTable('part_type')->execute();
			Yii::$app->db->createCommand()->truncateTable('product_part_type')->execute();
			Yii::$app->db->createCommand()->truncateTable('finance')->execute();
			$this->stdout("Cleaning data done.");
		}
	}
	
	/**
	 * Create one user that has site administrator role
	 * @param string $mobile
	 * @param string $email
	 * @param string $username
	 * @param string $password raw password
	 */
	public function actionCreateAdmin($mobile, $email, $username, $password)
	{
		$user = new User();
		$user->mobile = $mobile;
		$user->email = $email;
		$user->username = iconv("gbk", "utf-8", $username);
		$user->password = $password;
		$user->status = User::STATUS_ACTIVE;
		$user->generateAuthKey();
		
		if($user->save())
		{
			$role = Yii::$app->authManager->getRole("administrator");
			Yii::$app->authManager->assign($role, $user->id);
			
			$this->stdout("Create administrator with mobile " . $mobile . " done.");
		}
		else
		{
			$this->stderr("Create administrator with mobile " . $mobile . " failed with following errors.\n");
			foreach ($user->getErrors() as $attribute => $errors) {
				$this->stderr("<" . $attribute . ">\n");
				foreach ($errors as $error)
				{
					$this->stderr("  " . iconv("utf-8", "gbk", $error) . "\n");
				}
				$this->stderr("\n");
			}
		}
	}
}