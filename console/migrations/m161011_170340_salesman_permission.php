<?php

use yii\db\Migration;

class m161011_170340_salesman_permission extends Migration
{
    public function up()
    {
		$auth = \Yii::$app->authManager;
		$addOrder = $auth->getPermission("addOrder");
		$salesman = $auth->getRole("salesman");
		$auth->removeChild($salesman, $addOrder);
    }

    public function down()
    {
        $auth = \Yii::$app->authManager;
		$addOrder = $auth->getPermission("addOrder");
		$salesman = $auth->getRole("salesman");
		$auth->addChild($salesman, $addOrder);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
