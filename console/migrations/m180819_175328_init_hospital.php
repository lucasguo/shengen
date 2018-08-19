<?php

use yii\db\Migration;

/**
 * Class m180819_175328_init_hospital
 */
class m180819_175328_init_hospital extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $regionSql = file_get_contents(__DIR__ . '/hospital.sql');
        $this->execute($regionSql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180819_175328_init_hospital cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180819_175328_init_hospital cannot be reverted.\n";

        return false;
    }
    */
}
