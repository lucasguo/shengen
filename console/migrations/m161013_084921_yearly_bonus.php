<?php

use yii\db\Migration;

class m161013_084921_yearly_bonus extends Migration
{
    public function up()
    {
		$this->addColumn('bonus_setting', 'yearly_bonus', 'DECIMAL(8,2)');
		$this->update('bonus_setting', ['yearly_bonus' => 1]);
		$this->addColumn('user_relation', 'left_confirm_date', 'DATE NULL');
		$this->addColumn('user_relation', 'right_confirm_date', 'DATE NULL');
    }

    public function down()
    {
        $this->dropColumn('bonus_setting', 'yearly_bonus');
		$this->dropColumn('user_relation', 'left_confirm_date');
		$this->dropColumn('user_relation', 'right_confirm_date');
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
