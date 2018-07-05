<?php

use yii\db\Migration;

class m160719_093101_customer_maintain extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->alterColumn('customer', 'customer_address', 'TEXT NULL');
    	$this->addColumn('customer', 'customer_corp', 'VARCHAR(255)');
    	
    	$this->createTable('customer_maintain', [
    		'id' => $this->primaryKey(),
    		'content' => $this->text()->notNull(),
    		'customer_id' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->addForeignKey('customer_customer_maintain', 'customer_maintain', 'customer_id', 'customer', 'id', 'CASCADE');
    	
    	$this->createTable('alert', [
    		'id' => $this->primaryKey(),
    		'content' => $this->text()->notNull(),
    		'userid' => $this->integer()->notNull(),
    		'alert_date' => $this->date(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    }

    public function down()
    {
    	$this->dropForeignKey('customer_customer_maintain', 'customer_maintain');
        $this->dropTable('customer_maintain');
        $this->dropTable('alert');
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
