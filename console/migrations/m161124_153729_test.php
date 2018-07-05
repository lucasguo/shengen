<?php

use yii\db\Migration;
use common\models\User;
use backend\models\Customer;
use backend\models\MachineProduct;

class m161124_153729_test extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('{{%user_relation_test}}', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer()->notNull(),
    		'left_id' => $this->integer(),
    		'left_status' => $this->integer(),
    		'right_id' => $this->integer(),
    		'right_status' => $this->integer(),
    		'up_id' => $this->integer(),
    		'product_id' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createTable('user_bonus_test', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer()->notNull()->unique(),
    		'total_bonus' => $this->decimal(12,2)->defaultValue(0)->notNull(),
    		'available_bonus' => $this->decimal(12,2)->defaultValue(0)->notNull(),
    		'return_bonus' => $this->decimal(12,2)->defaultValue(0)->notNull(),
    		'sale_bonus' => $this->decimal(12,2)->defaultValue(0)->notNull(),
    		'manage_bonus' => $this->decimal(12,2)->defaultValue(0)->notNull(),
    		'sold_count' => $this->integer()->defaultValue(0),
    		'product_id' => $this->integer(),
    		'user_level' => $this->integer()->defaultValue(0),
    	], $tableOptions);
    	
    	$this->createTable('{{%user_test}}', [
    		'id' => $this->primaryKey(),
    		'username' => $this->string()->notNull()->unique(),
    		'status' => $this->smallInteger()->notNull()->defaultValue(10),
    		'customer_id' => $this->integer(),
    		'total_bonus' => $this->decimal(12, 2),
    		'available_bonus' => $this->decimal(12, 2),
    	], $tableOptions);
    	
    	$this->createTable('customer_test', [
    		'id' => $this->primaryKey(),
    		'customer_name' => $this->string()->notNull(),
    		'customer_status' => $this->integer(),
    	], $tableOptions);
    	
    	$this->createTable('level_test', [
    		'id' => $this->primaryKey(),
    		'level' => $this->integer(),
    	], $tableOptions);
    	
    	$this->insert('user_test', [
    		'username' => '用户1',
    		'status' => User::STATUS_ACTIVE,
    		'customer_id' => 1,
    		'total_bonus' => 0,
    		'available_bonus' => 0,
    	]);
    	
    	$this->insert('customer_test', [
    		'customer_name' => '用户1',
    		'customer_status' => Customer::STATUS_ACTIVE,
    	]);
    	
    	$this->insert('user_bonus_test', [
    		'user_id' => 1,
    		'product_id' => MachineProduct::getDefaultProduct()->id
    	]);
    	
    	$this->insert('level_test', [
    		'level' => 0,
    	]);
    }

    public function down()
    {
        $this->dropTable('user_relation_test');
        $this->dropTable('user_bonus_test');
        $this->dropTable('user_test');
        $this->dropTable('customer_test');
        $this->dropTable('level_test');
    }

}
