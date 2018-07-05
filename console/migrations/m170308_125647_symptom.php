<?php

use yii\db\Migration;

class m170308_125647_symptom extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->dropColumn('card_buyer', 'urgentperson');
        $this->dropColumn('card_buyer', 'urgentmobile');
        $this->addColumn('card_buyer', 'other_symptom', 'VARCHAR(30)');
        $this->alterColumn('card_buyer', 'symptom', 'INTEGER');
        $this->createTable('{{%symptom}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->insert('symptom', [
            'id' => 999,
            'name' => '其他',
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        echo "    > assign addCustomer to dealer ...";
        $auth = \Yii::$app->authManager;
        $dealer = $auth->getRole('dealer');
        $addPermission = $auth->getPermission('addCustomer');
        $auth->addChild($dealer, $addPermission);
        echo " done \n";
    }

    public function down()
    {
        $this->addColumn('card_buyer', 'urgentperson', 'VARCHAR(30)');
        $this->addColumn('card_buyer', 'urgentmobile', 'VARCHAR(30)');
        $this->dropColumn('card_buyer', 'other_symptom');
        $this->alterColumn('card_buyer', 'symptom', 'VARCHAR(30)');
        $this->dropTable('{{%symptom}}');
        $auth = \Yii::$app->authManager;
        $dealer = $auth->getRole('dealer');
        $permission = $auth->getPermission('addCustomer');
        $auth->removeChild($dealer, $permission);
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
