<?php

use yii\db\Migration;

class m161219_084404_disable_email extends Migration
{
    public function up()
    {
		$this->alterColumn('user', 'email', 'varchar(255) null');
    }

    public function down()
    {
        $this->alterColumn('user', 'email', 'varchar(255) not null');
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
