<?php

use yii\db\Migration;

class m160623_072941_usermobile extends Migration
{
    public function up()
    {
		$this->addColumn('user', 'mobile', 'char(11) not null');
		$this->createIndex('user-mobile-key', 'user', 'mobile', true);
		$this->dropIndex('username', 'user');
    }

    public function down()
    {
    	$this->dropIndex('user-mobile-key', 'user');
        $this->dropColumn('user', 'mobile');
		$this->createIndex('username', 'user', 'username');
        return true;
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
