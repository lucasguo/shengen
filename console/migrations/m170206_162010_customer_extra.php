<?php

use yii\db\Migration;

class m170206_162010_customer_extra extends Migration
{
    public function up()
    {
		$this->addColumn('customer', 'customer_type', 'INTEGER DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('customer', 'customer_type');
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
