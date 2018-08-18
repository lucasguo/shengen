<?php

use yii\db\Migration;

/**
 * Class m180818_030709_link_alarm
 */
class m180818_030709_link_alarm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_maintain_new', 'alert_id', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_maintain_new', 'alarm_id');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180818_030709_link_alarm cannot be reverted.\n";

        return false;
    }
    */
}
