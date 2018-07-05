<?php

use yii\db\Migration;

class m160627_070314_order extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('order_master', [
            'id' => $this->primaryKey(),
        	'customer_id' => $this->integer()->notNull(),
            'sold_count' => $this->integer()->notNull(),
        	'sold_amount' => $this->decimal(8, 2)->notNull(),
            'sold_datetime' => $this->integer(),
        	'need_invoice' => $this->boolean(),
        	'order_status' => $this->integer(),
        	'order_sn' => $this->string(),
        	'warranty_in_month' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createTable('order_detail', [
        	'id' => $this->primaryKey(),
        	'master_id' => $this->integer(),
	        'machine_id' => $this->integer(),
        	'expect_install_date' => $this->date(),
        	'install_date' => $this->date(),
        	'status' => $this->integer(),
	        'sold_price' => $this->decimal(8,2),
        ], $tableOptions);
        
        $this->addForeignKey('order_master_detail', 'order_detail', 'master_id', 'order_master', 'id', 'CASCADE');
        

    }

    public function down()
    {
    	$this->dropForeignKey('order_master_detail', 'order_detail');
        $this->dropTable('order_master');
        $this->dropTable('order_detail');
    }
}
