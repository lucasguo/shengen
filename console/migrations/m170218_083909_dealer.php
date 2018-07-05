<?php

use yii\db\Migration;

class m170218_083909_dealer extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('{{%dealer_shop}}', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer(),
    		'name' => $this->string()->notNull(),
    		'province' => $this->integer(),
    		'city' => $this->integer(),
    		'region' => $this->integer(),
    		'address' => $this->string(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createTable('{{%card_types}}', [
    		'id' => $this->primaryKey(),
    		'name' => $this->string()->notNull(),
    		'times' => $this->integer(),
    		'price' => $this->decimal(8,2),
    		'product_id' => $this->integer(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createTable('{{%card_buyer}}', [
    		'id' => $this->primaryKey(),
    		'buyername' => $this->string()->notNull(),
    		'sex' => $this->string(1)->notNull(),
    		'address' => $this->string(),
    		'shop_id' => $this->integer()->notNull(),
    		'mobile' => $this->string()->notNull(),
    		'urgentperson' => $this->string(),
    		'urgentmobile' => $this->string(),
    		'symptom' => $this->string(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createIndex('unique_card_buyer', '{{%card_buyer}}', ['shop_id', 'mobile'], true);
    	
    	$this->createTable('{{%card}}', [
    		'id' => $this->primaryKey(),
    		'card_type' => $this->integer()->notNull(),
    		'buyer_id' => $this->integer(),
    		'shop_id' => $this->integer(),
    		'left_times' => $this->integer(),
    		'sold_datetime' => $this->integer(),
    		'card_no' => $this->string(20),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	$this->createTable('{{%card_usage}}', [
    		'id' => $this->primaryKey(),
    		'card_id' => $this->integer(),
    		'buyer_id' => $this->integer()->notNull(),
    		'record' => $this->string(),
    		'helpername' => $this->string(10),
    		'use_datetime' => $this->integer(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%dealer_shop}}');
        $this->dropTable('{{%card_types}}');
        $this->dropTable('{{%card_buyer}}');
        $this->dropTable('{{%card}}');
        $this->dropTable('{{%card_usage}}');
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
