<?php

use yii\db\Migration;

class m160917_154029_aftersale extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('aftersale', [
    		'id' => $this->primaryKey(),
    		'user_id' => $this->integer()->notNull(),
    		'machine_id' => $this->integer(),
    		'description' => $this->text()->notNull()->comment("问题描述"),
    		'attachment' => $this->string(100)->comment("附加照片"),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('aftersale');
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
