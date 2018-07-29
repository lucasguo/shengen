<?php

use yii\db\Migration;

class m170218_070311_dealer_permission extends Migration
{
    public function up()
    {
    	echo "    > create role ...";
		$auth = \Yii::$app->authManager;
		$employee = $auth->createRole('dealerEmployee');
		$employee->description = '门店经销商员工';
		$auth->add($employee);
		$dealer = $auth->createRole('dealer');
		$dealer->description = '门店经销商';
		$auth->add($dealer);
		$admin = $auth->getRole('administrator');
		echo " done \n";
		
		echo "    > create permissions ...";
		$addEmployee = $auth->createPermission('addEmployee');
		$addEmployee->description = '添加门店员工';
		$auth->add($addEmployee);
		$auth->addChild($dealer, $addEmployee);
		
		$addCardBuyer = $auth->createPermission('addCardBuyer');
		$addCardBuyer->description = '添加购卡顾客';
		$auth->add($addCardBuyer);
		$auth->addChild($dealer, $addCardBuyer);
		$auth->addChild($employee, $addCardBuyer);
		
		$addCardUsage = $auth->createPermission('addCardUsage');
		$addCardUsage->description = '添加顾客用卡记录';
		$auth->add($addCardUsage);
		$auth->addChild($dealer, $addCardUsage);
		$auth->addChild($employee, $addCardUsage);
		
		$viewOwnCardBuyer = $auth->createPermission('viewOwnCardBuyer');
		$viewOwnCardBuyer->description = '查看门店购卡顾客';
		$auth->add($viewOwnCardBuyer);
		$auth->addChild($dealer, $viewOwnCardBuyer);
		
		$viewAllCardBuyer = $auth->createPermission('viewAllCardBuyer');
		$viewAllCardBuyer->description = '查看所有购卡顾客';
		$auth->add($viewAllCardBuyer);
		$auth->addChild($admin, $viewAllCardBuyer);
		
		$maintainCardType = $auth->createPermission('maintainCardType');
		$maintainCardType->description = '维护卡类型';
		$auth->add($maintainCardType);
		$auth->addChild($admin, $maintainCardType);
		
		$maintainDealerShop = $auth->createPermission('maintainDealerShop');
		$maintainDealerShop->description = '维护经销商门店';
		$auth->add($maintainDealerShop);
		$auth->addChild($admin, $maintainDealerShop);
		echo " done \n";
    }

    public function down()
    {
        $auth = \Yii::$app->authManager;
        
        echo "    > remove permissions ...";
        $addEmployee = $auth->getPermission('addEmployee');
		$auth->remove($addEmployee);
        
        $addCardBuyer = $auth->getPermission('addCardBuyer');
        $auth->remove($addCardBuyer);
        
        $addCardUsage = $auth->getPermission('addCardUsage');
        $auth->remove($addCardUsage);
        
        $viewOwnCardBuyer = $auth->getPermission('viewOwnCardBuyer');
        $auth->remove($viewOwnCardBuyer);
        
        $viewAllCardBuyer = $auth->getPermission('viewAllCardBuyer');
        $auth->remove($viewAllCardBuyer);
        
        $maintainCardType = $auth->getPermission('maintainCardType');
        $auth->remove($maintainCardType);
        echo " done \n";
        
        echo "    > remove role ...";
        $employee = $auth->getRole('employee');
        $auth->remove($employee);
        echo " done \n";
        
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
