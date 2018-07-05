<?php

use yii\db\Migration;

class m161012_153602_change_user_bonus extends Migration
{
    public function up()
    {
		$this->dropColumn('user_bonus', 'sold_count');
		$this->dropColumn('user_bonus', 'up_id');
		$this->addColumn('user_bonus', 'user_level', 'INTEGER NOT NULL DEFAULT 0');
		$this->addColumn('bonus_setting', 'single_cost', 'DECIMAL(10,2) NOT NULL');
		$this->update('bonus_setting', ['single_cost' => 3500]);
    }

    public function down()
    {
        $this->addColumn('user_bonus', 'sold_count', 'INTEGER NOT NULL DEFAULT 0');
		$this->addColumn('user_bonus', 'up_id', 'INTEGER NULL');
		$this->dropColumn('user_bonus', 'user_level');
		$this->dropColumn('bonus_setting', 'single_cost');
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
