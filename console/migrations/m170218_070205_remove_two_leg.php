<?php

use yii\db\Migration;

class m170218_070205_remove_two_leg extends Migration
{
    public function up()
    {
		$this->dropTable('bonus_log_double_fork');
		$this->dropTable('bonus_log_single');
		$this->dropTable('bonus_log_single_fork');
		$this->dropTable('customer_test');
		$this->dropTable('level_test');
		$this->dropTable('order_double_fork');
		$this->dropTable('order_single');
		$this->dropTable('order_single_fork');
		$this->dropTable('user_bonus_double_fork');
		$this->dropTable('user_bonus_single');
		$this->dropTable('user_bonus_single_fork');
		$this->dropTable('user_bonus_test');
		$this->dropTable('user_relation_test');
		$this->dropTable('user_test');
		$this->dropTable('user_double_fork');
		$this->dropTable('user_single');
		$this->dropTable('user_single_fork');

		$this->dropColumn('user_relation', 'left_id');
		$this->dropColumn('user_relation', 'left_status');
		$this->dropColumn('user_relation', 'left_confirm_date');
		$this->dropColumn('user_relation', 'right_id');
		$this->dropColumn('user_relation', 'right_status');
		$this->dropColumn('user_relation', 'right_confirm_date');
    }

    public function down()
    {
        echo "m170218_070205_remove_two_leg cannot be reverted.\n";

        return false;
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
