<?php

use yii\db\Migration;

/**
 * Class m180812_025915_hospital
 */
class m180812_025915_hospital extends Migration
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

        $this->createTable('hospital', [
            'id' => $this->primaryKey(),
            'hospital_name' => $this->string(40)->notNull()->unique(),
            'hospital_province' => $this->integer()->notNull()->defaultValue(16),
            'hospital_city' => $this->integer()->notNull(),
            'hospital_district' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], $tableOptions);

        $auth = \Yii::$app->authManager;
        $adminSite = $auth->createPermission('adminSite');
        $adminSite->description = '站点基础信息管理';
        $auth->add($adminSite);
        $admin = $auth->getRole('administrator');
        $auth->addChild($admin, $adminSite);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hospital');

        $auth = \Yii::$app->authManager;
        $adminSite = $auth->getPermission('adminSite');
        $auth->remove($adminSite);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180812_025915_hospital cannot be reverted.\n";

        return false;
    }
    */
}
