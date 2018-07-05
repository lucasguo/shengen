<?php

use yii\db\Migration;

class m170224_011552_shop_relation extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'shop_id', 'INTEGER NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'shop_id');
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
