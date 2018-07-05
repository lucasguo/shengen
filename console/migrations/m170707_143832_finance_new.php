<?php

use yii\db\Migration;

class m170707_143832_finance_new extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('finance_new', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'amount' => $this->decimal(9,2)->notNull(),
            'userid' => $this->integer(),
            'occur_date' => $this->date()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->integer()->notNull(),
            'relate_table' => $this->string(20),
            'relate_id' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('finance_new');
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
