<?php

use yii\db\Migration;

class m170305_231408_article extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer(),
            'is_top' => $this->boolean(),
            'title' => $this->string()->notNull(),
            'source' => $this->string(100),
            'content' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        echo "    > create role ...";
        $auth = \Yii::$app->authManager;
        $clerk = $auth->createRole('clerk');
        $clerk->description = '文员';
        $auth->add($clerk);
        $admin = $auth->getRole('administrator');
        echo " done \n";

        echo "    > create permissions ...";
        $maintainArticle = $auth->createPermission('maintainArticle');
        $maintainArticle->description = '维护文章';
        $auth->add($maintainArticle);
        $auth->addChild($clerk, $maintainArticle);

        $auth->addChild($admin, $maintainArticle);

        echo " done \n";
    }

    public function down()
    {
        $this->dropTable('{{%article}}');
        $auth = \Yii::$app->authManager;
        $admin = $auth->getRole('administrator');
        $clerk = $auth->getRole('clerk');
        $maintainArticle = $auth->getPermission('maintainArticle');
        $auth->removeChild($admin, $maintainArticle);
        $auth->removeChild($clerk, $maintainArticle);
        $auth->remove($maintainArticle);
        $auth->remove($clerk);
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
