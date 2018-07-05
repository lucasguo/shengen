<?php

use yii\db\Migration;

class m170218_100809_region extends Migration
{
    public function up()
    {
		$regionSql = file_get_contents(__DIR__ . '/region.sql');
		$this->execute($regionSql);
    }

    public function down()
    {
        $this->dropTable('region');
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
