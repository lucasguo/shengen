<?php

use yii\db\Migration;
use common\models\User;

class m161009_145635_meeting_record extends Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    	}
    	
    	$this->createTable('{{%meeting_record}}', [
    		'id' => $this->primaryKey(),
    		'meeting_date' => $this->date()->notNull(),
    		'file_path' => $this->string()->notNull(),
    		'created_at' => $this->integer()->notNull(),
    		'updated_at' => $this->integer()->notNull(),
    		'created_by' => $this->integer()->notNull(),
    		'updated_by' => $this->integer()->notNull(),
    	], $tableOptions);
    	
    	echo "    > create meeting permissions ...";
    	$auth = \Yii::$app->authManager;
    	
    	$meetingRecord = $auth->createPermission("meetingRecord");
    	$meetingRecord->description = "上传和查看会议记录";
    	$auth->add($meetingRecord);
    	
    	
    	$member = $auth->createRole("coreMember");
    	$member->description = "核心团队成员";
    	$auth->add($member);
    	$auth->addChild($member, $meetingRecord);
    	
    	$users = User::find()->all();
    	foreach ($users as $user) {
    		$auth->assign($member, $user->id);
    	}
    	
    	echo "done.\n";
    }

    public function down()
    {
        $this->dropTable('{{%meeting_record}}');
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
