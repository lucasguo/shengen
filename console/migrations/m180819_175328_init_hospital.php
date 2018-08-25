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
        $orgSql = file_get_contents(__DIR__ . '/hospital.sql');
        $hospitalSql = mb_convert_encoding($orgSql, 'UTF-8',
            mb_detect_encoding($orgSql, 'UTF-8, ISO-8859-1', true));
        $this->execute($hospitalSql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('hospital', ['>', 'id', 3]);
        return true;
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
