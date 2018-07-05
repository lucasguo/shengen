<?php

use yii\db\Migration;
use yii\db\Schema;

class m160918_140540_fix_bonus extends Migration
{
    public function up()
    {
		$this->dropColumn('user_bonus', 'total_bonus');
		$this->dropColumn('user_bonus', 'available_bonus');
		$this->addColumn('user_bonus', 'up_id', Schema::TYPE_INTEGER . ' NULL');
		
		$this->addColumn('user', 'total_bonus', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL DEFAULT 0');
		$this->addColumn('user', 'available_bonus', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL DEFAULT 0');
		$this->dropColumn('user', 'up_id');
    }

    public function down()
    {
        $this->addColumn('user_bonus', 'total_bonus', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL DEFAULT 0');
		$this->addColumn('user_bonus', 'available_bonus', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL DEFAULT 0');
		$this->dropColumn('user_bonus', 'up_id');
		
		$this->dropColumn('user', 'total_bonus');
		$this->dropColumn('user', 'available_bonus');
		$this->addColumn('user', 'up_id', Schema::TYPE_INTEGER . ' NULL');
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
