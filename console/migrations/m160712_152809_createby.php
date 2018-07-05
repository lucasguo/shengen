<?php

use yii\db\Migration;

class m160712_152809_createby extends Migration
{
    public function up()
    {
		$this->addColumn('customer', 'created_by', 'integer');
		$this->addColumn('customer', 'updated_by', 'integer');
		
		$this->addColumn('machine', 'created_by', 'integer');
		$this->addColumn('machine', 'updated_by', 'integer');
		
		$this->addColumn('machine_part', 'created_by', 'integer');
		$this->addColumn('machine_part', 'updated_by', 'integer');
		
		$this->addColumn('machine_product', 'created_by', 'integer');
		$this->addColumn('machine_product', 'updated_by', 'integer');
		
		$this->addColumn('order_detail', 'created_at', 'integer');
		$this->addColumn('order_detail', 'updated_at', 'integer');
		$this->addColumn('order_detail', 'created_by', 'integer');
		$this->addColumn('order_detail', 'updated_by', 'integer');
		
		$this->addColumn('order_master', 'created_by', 'integer');
		$this->addColumn('order_master', 'updated_by', 'integer');
		
		$this->addColumn('part', 'created_by', 'integer');
		$this->addColumn('part', 'updated_by', 'integer');
		
		$this->addColumn('part_type', 'created_by', 'integer');
		$this->addColumn('part_type', 'updated_by', 'integer');
		
		$this->addColumn('product_part_type', 'created_by', 'integer');
		$this->addColumn('product_part_type', 'updated_by', 'integer');
		
		$this->addColumn('user', 'created_by', 'integer');
		$this->addColumn('user', 'updated_by', 'integer');
    }

    public function down()
    {
        $this->dropColumn('customer', 'created_by');
		$this->dropColumn('customer', 'updated_by');
		
		$this->dropColumn('machine', 'created_by');
		$this->dropColumn('machine', 'updated_by');
		
		$this->dropColumn('machine_part', 'created_by');
		$this->dropColumn('machine_part', 'updated_by');
		
		$this->dropColumn('machine_product', 'created_by');
		$this->dropColumn('machine_product', 'updated_by');
		
		$this->dropColumn('order_detail', 'created_at');
		$this->dropColumn('order_detail', 'updated_at');
		$this->dropColumn('order_detail', 'created_by');
		$this->dropColumn('order_detail', 'updated_by');
		
		$this->dropColumn('order_master', 'created_by');
		$this->dropColumn('order_master', 'updated_by');
		
		$this->dropColumn('part', 'created_by');
		$this->dropColumn('part', 'updated_by');
		
		$this->dropColumn('part_type', 'created_by');
		$this->dropColumn('part_type', 'updated_by');
		
		$this->dropColumn('product_part_type', 'created_by');
		$this->dropColumn('product_part_type', 'updated_by');
		
		$this->dropColumn('user', 'created_by');
		$this->dropColumn('user', 'updated_by');
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
