<?php

use yii\db\Migration;
use backend\models\MeetingRecord;

class m161021_133758_inner_file extends Migration
{
    public function up()
    {
		$this->alterColumn("meeting_record", 'meeting_date', 'date NULL');
		$this->addColumn('meeting_record', 'org_name', 'VARCHAR(50) NOT NULL');
		$this->addColumn('meeting_record', 'topic', 'TEXT NULL');
		$this->addColumn('meeting_record', 'file_type', 'INTEGER NOT NULL');
		$this->update('meeting_record', ['file_type' => MeetingRecord::FILE_TYPE_MEETING]);
    }

    public function down()
    {
        $this->dropColumn('meeting_record', 'org_name');
		$this->dropColumn('meeting_record', 'topic');
		$this->dropColumn('meeting_record', 'file_type');
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
