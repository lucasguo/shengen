<?php

use yii\db\Migration;

/**
 * Class m180812_080803_customer_new_extend
 */
class m180812_080803_customer_new_extend extends Migration
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

        $this->createTable('customer_hospital_mapping', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'hospital_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('customer_hospital_mapping_customer_id', 'customer_hospital_mapping', 'customer_id');

        $this->addColumn('customer_new', 'city_id', 'integer');

        $this->createTable('customer_new_extend', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'gender' => $this->tinyInteger()->notNull(),
            'birth_year' => $this->integer()->defaultValue(1),
            'diagnosis' => $this->string(100),
            'disease_course' => $this->string(100),
            'treat_plan' => $this->string(100),
            'doctor_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('customer_new_extend_customer_id', 'customer_new_extend', 'customer_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customer_hospital_mapping');
        $this->dropTable('customer_new_extend');
        $this->dropColumn('customer_new', 'city_id');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180812_080803_customer_new_extend cannot be reverted.\n";

        return false;
    }
    */
}
