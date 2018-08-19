<?php

use yii\db\Migration;

/**
 * Class m180819_094305_order_new
 */
class m180819_094305_order_new extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('order_new', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'sell_count' => $this->integer(),
            'customer_id' => $this->integer()->notNull(),
            'order_status' => $this->integer()->notNull(),
            'org_order_id' => $this->integer(),
            'sell_amount' => $this->decimal(10,2),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_new');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180819_094305_order_new cannot be reverted.\n";

        return false;
    }
    */
}
