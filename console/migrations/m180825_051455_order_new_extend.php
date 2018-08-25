<?php

use yii\db\Migration;

/**
 * Class m180825_051455_order_new_extend
 */
class m180825_051455_order_new_extend extends Migration
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

        $this->createTable('counterman', [
            'id' => $this->primaryKey(),
            'counterman_name' => $this->string(64)->notNull(),
            'city_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addColumn('order_new', 'counterman_id', 'integer');
        $this->addColumn('order_new', 'dealer_id', 'integer');
        $this->addColumn('order_new', 'hospital_id', 'integer');
        $this->addColumn('order_new', 'order_date', 'integer');
        $this->addColumn('order_new', 'office', 'varchar(64)');
        $this->dropColumn('order_new', 'customer_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('counterman');
        $this->dropColumn('order_new', 'counterman_id');
        $this->dropColumn('order_new', 'dealer_id');
        $this->dropColumn('order_new', 'hospital_id');
        $this->dropColumn('order_new', 'order_date');
        $this->dropColumn('order_new', 'office');
        $this->addColumn('order_new', 'customer_id', 'integer');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180825_051455_order_new_extend cannot be reverted.\n";

        return false;
    }
    */
}
