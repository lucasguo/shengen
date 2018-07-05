<?php

use yii\db\Migration;

class m160722_092034_customersn extends Migration
{
    public function up()
    {
		$this->addColumn('customer', 'customer_sn', 'varchar(30) not null');
    }

    public function down()
    {
        $this->dropColumn('customer', 'customer_sn');
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
