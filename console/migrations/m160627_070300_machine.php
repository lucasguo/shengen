<?php

use yii\db\Migration;

class m160627_070300_machine extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('machine_product', [
        	'id' => $this->primaryKey(),
        	'product_code' => $this->string()->notNull()->unique(),
        	'product_name' => $this->string()->notNull(),
        	'product_status' => $this->integer(),
        	'created_at' => $this->integer()->notNull(),
        	'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createTable('machine', [
            'id' => $this->primaryKey(),
        	'product_id' => $this->integer()->notNull(),
            'machine_sn' => $this->string()->notNull()->unique(),
        	'machine_cost' => $this->decimal(8,2)->notNull(),
        	'machine_status' => $this->integer(),
            'in_datetime' => $this->date(),
        	'out_datetime' => $this->date(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createTable('machine_part', [
        	'id' => $this->primaryKey(),
        	'machine_id' => $this->integer(),
        	'part_id' => $this->integer(),
        	'part_type_id' => $this->integer(),
        	'created_at' => $this->integer()->notNull(),
        	'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
		$this->createTable('part_type', [
            'id' => $this->primaryKey(),
        	'part_name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
		
		$this->createTable('product_part_type', [
			'id' => $this->primaryKey(),
			'product_id' => $this->integer()->notNull(),
			'part_type_id' => $this->integer()->notNull(),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);
		
		$this->createTable('part', [
			'id' => $this->primaryKey(),
			'part_type' => $this->integer()->notNull(),
			'part_sn' => $this->string(),
			'status' => $this->integer(),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);
        
    }

    public function down()
    {
    	$this->dropTable('machine_product');
        $this->dropTable('machine');
        $this->dropTable('part_type');
        $this->dropTable('product_part_type');
        $this->dropTable('machine_part');
        $this->dropTable('part');
    }
}
