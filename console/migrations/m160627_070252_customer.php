<?php

use yii\db\Migration;

class m160627_070252_customer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('customer', [
            'id' => $this->primaryKey(),
            'customer_name' => $this->string()->notNull(),
            'customer_mobile' => $this->string(25)->notNull()->unique(),
            'customer_address' => $this->text()->notNull(),
        	'customer_status' => $this->integer(),
            'belongto' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('customer');
    }
}
