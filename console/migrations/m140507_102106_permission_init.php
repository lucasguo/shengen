<?php

use yii\db\Migration;

class m140507_102106_permission_init extends Migration
{
    public function up()
    {
        echo "    > create default permissions ...";
        $auth = \Yii::$app->authManager;

        $role1 = $auth->createRole('salesman');
        $role1->description = '业务员';
        $auth->add($role1);

        $role2 = $auth->createRole('accountant');
        $role2->description = '财务';
        $auth->add($role2);

        $role3 = $auth->createRole('aftersales');
        $role3->description = '售后服务人员';
        $auth->add($role3);

        $role4 = $auth->createRole('warehousing');
        $role4->description = '仓管';
        $auth->add($role4);

        $role5 = $auth->createRole('administrator');
        $role5->description = '系统管理员';
        $auth->add($role5);

        $permission1 = $auth->createPermission('addCustomer');
        $permission1->description = '添加顾客';
        $auth->add($permission1);

        $permission2 = $auth->createPermission('addFinance');
        $permission2->description = '添加财务条目';
        $auth->add($permission2);

        $permission3 = $auth->createPermission('viewFinance');
        $permission3->description = '查看财务条目';
        $auth->add($permission3);

        $auth->addChild($role5, $permission1);
        $auth->addChild($role5, $permission2);
        $auth->addChild($role5, $permission3);
        echo " done \n";
    }

    public function down()
    {
        $auth = \Yii::$app->authManager;

        echo "    > remove permissions ...";
        $role1 = $auth->getRole('salesman');

        $role2 = $auth->getRole('accountant');

        $role3 = $auth->getRole('aftersales');

        $role4 = $auth->getRole('warehousing');

        $role5 = $auth->getRole('administrator');

        $auth->remove($role1);
        $auth->remove($role2);
        $auth->remove($role3);
        $auth->remove($role4);
        $auth->remove($role5);

        $permission1 = $auth->getPermission('addCustomer');
        $auth->remove($permission1);

        $permission2 = $auth->getPermission('addFinance');
        $auth->remove($permission2);

        $permission3 = $auth->getPermission('viewFinance');
        $auth->remove($permission3);

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
