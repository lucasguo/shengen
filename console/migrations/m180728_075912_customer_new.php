<?php

use yii\db\Migration;

/**
 * Class m180728_075912_customer_new
 */
class m180728_075912_customer_new extends Migration
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

        $this->createTable('customer_new', [
            'id' => $this->primaryKey(),
            'customer_name' => $this->string(10)->notNull(),
            'customer_mobile' => $this->string(15)->notNull()->unique(),
            'customer_company' => $this->string(50)->notNull()->defaultValue(""),
            'customer_job' => $this->string(20)->notNull()->defaultValue(""),
            'customer_type' => $this->smallInteger()->notNull(),
            'comment' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('customer_maintain_new', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'alert_date' => $this->integer()->notNull(),
            'alert_time' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customer_new');
        $this->dropTable('customer_maintain_new');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180728_075912_customer_new cannot be reverted.\n";

        return false;
    }
    */
}
