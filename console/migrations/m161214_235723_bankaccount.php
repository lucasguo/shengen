<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m161214_235723_bankaccount extends Migration
{
    public function up()
    {
		$this->addColumn('customer', 'bankaccount', 'VARCHAR(30)');
		$this->addColumn('customer', 'bankname', 'VARCHAR(80)');
		$this->addColumn('customer', 'beneficiary', 'VARCHAR(10)');
		$this->addColumn('user', 'bankaccount', 'VARCHAR(30)');
		$this->addColumn('user', 'bankname', 'VARCHAR(80)');
		$this->addColumn('user', 'beneficiary', 'VARCHAR(10)');
		$this->addColumn('customer', 'auto_convert', 'BOOLEAN');
    }

    public function down()
    {
        $this->dropColumn('customer', 'bankaccount');
		$this->dropColumn('customer', 'bankname');
		$this->dropColumn('customer', 'beneficiary');
		$this->dropColumn('user', 'bankaccount');
		$this->dropColumn('user', 'bankname');
		$this->dropColumn('user', 'beneficiary');
		$this->dropColumn('customer', 'auto_convert');
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
