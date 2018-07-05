<?php

use yii\db\Migration;

class m161007_085758_user_relation extends Migration
{
public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_relation}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'left_id' => $this->integer(),
        	'left_status' => $this->integer(),
            'right_id' => $this->integer(),
        	'right_status' => $this->integer(),
            'up_id' => $this->integer(),
        	'product_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_relation}}');
    }
}
