<?php

use yii\db\Migration;
use backend\models\MachineProduct;
use backend\helpers\BonusHelper;

class m160918_171554_bonus_test extends Migration
{
	
    public function up()
    {
    	$this->createSingle();
    	$this->createSingleFork();
    	$this->createDoubleFork();
    }

    public function down()
    {
        $this->removeSingle();
        $this->removeSingleFork();
        $this->removeDoubleFork();
    }
    
    public function createSingle()
    {
    	$defaultProductId = MachineProduct::getDefaultProduct()->id;
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM';
    	}
    	 
    	$this->createTable('user_single', [
    		'id' => $this->primaryKey(),
    		'total_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'available_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'customer_id' => $this->integer(),
    	], $tableOptions);
    	
    	$this->insert('user_single', [
    		'id' => 1,
    		'total_bonus' => 0,
    		'available_bonus' => 0,
    		'customer_id' => 1,
    	]);
    	 
    	$this->createTable('user_bonus_single', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer(),
    		'return_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sale_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'manage_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sold_count' => $this->integer()->defaultValue(0),
    		'product_id' => $this->integer(),
    		'up_id' => $this->integer()->null(),
    	], $tableOptions);
    	
    	$this->insert('user_bonus_single', [
    		'user_id' => 1,
    		'return_bonus' => 0,
    		'sale_bonus' => 0,
    		'manage_bonus' => 0,
    		'sold_count' => 0,
    		'product_id' => $defaultProductId,
    	]);
    	 
    	$this->createTable('order_single', [
    		'id' => $this->primaryKey(),
    		'customer_id' => $this->integer(),
    		'sold_count' => $this->integer(),
    		'product_id' => $this->integer(),
    		'created_by' => $this->integer(),
    	], $tableOptions);
    	
    	$this->insert('order_single', [
    		'customer_id' => 1,
    		'sold_count' => 1,
    		'product_id' => $defaultProductId,
    		'created_by' => -1,
    	]);
    	
    	$columns = ['customer_id', 'sold_count', 'product_id', 'created_by'];
    	$rows = [];
    	for ($i = 2; $i <= BonusHelper::MAX_LEVEL_USER_COUNT + 1; $i++) {
    		$rows[] = [1, 1, $defaultProductId, 1];
    	}
    	echo "    > begin batch insert single orders ...";
    	$this->db->createCommand()->batchInsert('order_single', $columns, $rows)->execute();
    	echo " done.\n"; 
    	
    	$this->createTable('bonus_log_single', [
    		'id' => $this->primaryKey(),
    		'product_id' => $this->integer(),
    		'user_id' => $this->integer(),
    		'order_id' => $this->integer(),
    		'sold_critical' => $this->integer(),
    		'bonus_type' => $this->integer(),
    		'bonus_amount' => $this->decimal(12,2),
    		'bonus_date' => $this->date(),
    	], $tableOptions);
    }
    
    public function removeSingle()
    {
    	$this->dropTable('user_single');
    	$this->dropTable('user_bonus_single');
    	$this->dropTable('order_single');
    	$this->dropTable('bonus_log_single');
    }
    
    public function createSingleFork()
    {
    	$defaultProductId = MachineProduct::getDefaultProduct()->id;
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM';
    	}
    	
    	$this->createTable('user_single_fork', [
    		'id' => $this->primaryKey(),
    		'total_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'available_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'customer_id' => $this->integer(),
    	], $tableOptions);
    	 
    	$userColumns = ['id', 'total_bonus', 'available_bonus', 'customer_id'];
    	$userRows = [];
    	for ($i = 1; $i <= BonusHelper::MAX_LEVEL_USER_COUNT; $i++) {
    		$userRows[] = [$i, 0, 0, $i];
    	}
    	echo "    > begin batch insert single fork users ...";
    	$this->db->createCommand()->batchInsert('user_single_fork', $userColumns, $userRows)->execute();
    	echo " done.\n";
    	
    	$this->createTable('user_bonus_single_fork', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer(),
    		'return_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sale_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'manage_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sold_count' => $this->integer()->defaultValue(0),
    		'product_id' => $this->integer(),
    		'up_id' => $this->integer()->null(),
    	], $tableOptions);
    	 
    	$this->insert('user_bonus_single_fork', [
    		'user_id' => 1,
    		'product_id' => $defaultProductId,
    	]);
    	$bonusColumns = ['user_id', 'product_id', 'up_id'];
    	$bonusRows = [];
    	for ($i = 2; $i <= BonusHelper::MAX_LEVEL_USER_COUNT; $i++) {
    		$bonusRows[] = [$i, $defaultProductId, $i - 1];
    	}
    	echo "    > begin batch insert single fork bonus ...";
    	$this->db->createCommand()->batchInsert('user_bonus_single_fork', $bonusColumns, $bonusRows)->execute();
    	echo " done.\n";
    	
    	$this->createTable('order_single_fork', [
    		'id' => $this->primaryKey(),
    		'customer_id' => $this->integer(),
    		'sold_count' => $this->integer(),
    		'product_id' => $this->integer(),
    		'created_by' => $this->integer(),
    	], $tableOptions);
    	 
    	$this->insert('order_single_fork', [
    		'customer_id' => 1,
    		'sold_count' => 1,
    		'product_id' => $defaultProductId,
    		'created_by' => -1,
    	]);
    	$orderColumns = ['customer_id', 'sold_count', 'product_id', 'created_by'];
    	$orderRows = [];
    	for ($i = 2; $i <= BonusHelper::MAX_LEVEL_USER_COUNT + 1; $i++) {
    		$orderRows[] = [$i, 1, $defaultProductId, $i - 1];
    	}
    	echo "    > begin batch insert single fork orders ...";
    	$this->db->createCommand()->batchInsert('order_single_fork', $orderColumns, $orderRows)->execute();
    	echo " done.\n";
    	
    	$this->createTable('bonus_log_single_fork', [
    		'id' => $this->primaryKey(),
    		'product_id' => $this->integer(),
    		'user_id' => $this->integer(),
    		'order_id' => $this->integer(),
    		'sold_critical' => $this->integer(),
    		'bonus_type' => $this->integer(),
    		'bonus_amount' => $this->decimal(12,2),
    		'bonus_date' => $this->date(),
    	], $tableOptions);
    }
    
    public function removeSingleFork()
    {
    	$this->dropTable('user_single_fork');
    	$this->dropTable('user_bonus_single_fork');
    	$this->dropTable('order_single_fork');
    	$this->dropTable('bonus_log_single_fork');
    }
    
    public function createDoubleFork()
    {
    	$defaultProductId = MachineProduct::getDefaultProduct()->id;
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM';
    	}
    	 
    	$this->createTable('user_double_fork', [
    		'id' => $this->primaryKey(),
    		'total_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'available_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'customer_id' => $this->integer(),
    	], $tableOptions);
    	
    	$userColumns = ['id', 'total_bonus', 'available_bonus', 'customer_id'];
    	$userRows = [];
    	for ($i = 1; $i <= BonusHelper::MAX_LEVEL_USER_COUNT; $i++) {
    		$userRows[] = [$i, 0, 0, $i];
    	}
    	echo "    > begin batch insert double fork users ...";
    	$this->db->createCommand()->batchInsert('user_double_fork', $userColumns, $userRows)->execute();
    	echo " done.\n";
    	 
    	$this->createTable('user_bonus_double_fork', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer(),
    		'return_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sale_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'manage_bonus' => $this->decimal(12,2)->defaultValue(0),
    		'sold_count' => $this->integer()->defaultValue(0),
    		'product_id' => $this->integer(),
    		'up_id' => $this->integer()->null(),
    	], $tableOptions);
    	
    	$this->insert('user_bonus_double_fork', [
    		'user_id' => 1,
    		'product_id' => $defaultProductId,
    	]);
    	$bonusColumns = ['user_id', 'product_id', 'up_id'];
    	$bonusRows = [];
    	for ($i = 2; $i <= BonusHelper::MAX_LEVEL_USER_COUNT; $i++) {
    		$up = floor($i / 2);
    		$bonusRows[] = [$i, $defaultProductId, $up];
    	}
    	echo "    > begin batch insert double fork bonus ...";
    	$this->db->createCommand()->batchInsert('user_bonus_double_fork', $bonusColumns, $bonusRows)->execute();
    	echo " done.\n";
    	 
    	$this->createTable('order_double_fork', [
    		'id' => $this->primaryKey(),
    		'customer_id' => $this->integer(),
    		'sold_count' => $this->integer(),
    		'product_id' => $this->integer(),
    		'created_by' => $this->integer(),
    	], $tableOptions);
    	
    	$this->insert('order_double_fork', [
    		'customer_id' => 1,
    		'sold_count' => 1,
    		'product_id' => $defaultProductId,
    		'created_by' => -1,
    	]);
    	
    	$orderColumns = ['customer_id', 'sold_count', 'product_id', 'created_by'];
    	$orderRows = [];
    	for ($i = 2; $i <= BonusHelper::MAX_LEVEL_USER_COUNT + 1; $i++) {
    		$up = floor($i / 2);
    		$orderRows[] = [$i, 1, $defaultProductId, $up];
    	}
    	echo "    > begin batch insert double fork orders ...";
    	$this->db->createCommand()->batchInsert('order_double_fork', $orderColumns, $orderRows)->execute();
    	echo " done.\n";
    	 
    	$this->createTable('bonus_log_double_fork', [
    		'id' => $this->primaryKey(),
    		'product_id' => $this->integer(),
    		'user_id' => $this->integer(),
    		'order_id' => $this->integer(),
    		'sold_critical' => $this->integer(),
    		'bonus_type' => $this->integer(),
    		'bonus_amount' => $this->decimal(12,2),
    		'bonus_date' => $this->date(),
    	], $tableOptions);
    }
    
    public function removeDoubleFork()
    {
    	$this->dropTable('user_double_fork');
    	$this->dropTable('user_bonus_double_fork');
    	$this->dropTable('order_double_fork');
    	$this->dropTable('bonus_log_double_fork');
    }

}
