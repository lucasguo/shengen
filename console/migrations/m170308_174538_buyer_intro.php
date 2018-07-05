<?php

use yii\db\Migration;

class m170308_174538_buyer_intro extends Migration
{
    public function up()
    {
        $this->addColumn('card_buyer', 'intro_type', 'INTEGER DEFAULT 0');
        $this->addColumn('card_buyer', 'intro_name', 'VARCHAR(50)');
    }

    public function down()
    {
        $this->dropColumn('card_buyer', 'intro_type');
        $this->dropColumn('card_buyer', 'intro_name');
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
