<?php

use yii\db\Migration;

class m160909_153054_wechat_connect extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('wechat_connect', [
    		'id' => $this->primaryKey(),
    		'userid' => $this->integer()->notNull(),
    		'openid' => $this->string(40)->notNull()->unique(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    	], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('wechat_connect');
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
