<?php

use yii\db\Migration;
use yii\db\Schema;

class m160917_174224_bonus extends Migration
{
    public function up()
    {
		$this->addColumn('order_master', 'allow_return', 'TINYINT NOT NULL DEFAULT 1');
		$this->addColumn('order_master', 'sold_date', Schema::TYPE_DATE . " NULL");
		$this->addColumn('order_master', 'confirm_date', Schema::TYPE_DATE . " NULL");
		$this->addColumn('order_master', 'out_date', Schema::TYPE_DATE . " NULL");
		$this->addColumn('order_master', 'product_id', Schema::TYPE_INTEGER . " NOT NULL");
		
		$this->addColumn('machine_product', 'is_default', Schema::TYPE_SMALLINT . " DEFAULT 0");
		
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('bonus_setting', [
			'id' => $this->primaryKey(),
			'single_price' => $this->decimal(8,2)->notNull()->comment("单台售价"),
			'once_return' => $this->decimal(8,2)->notNull()->comment("销售立返(元)"),
			'sale_bonus' => $this->decimal(8,2)->notNull()->comment("销售奖单台提成比例"),
			'manage_bonus' => $this->decimal(8,2)->notNull()->comment("管理奖对下级提成比例"),
			'level_limit' => $this->integer()->notNull()->comment("最多级数"),
			'return_day_limit' => $this->integer()->notNull()->comment("最大允许退货天数"),
			'product_id' => $this->integer()->notNull()->comment('产品'),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
			'created_by' => $this->integer()->notNull(),
			'updated_by' => $this->integer()->notNull(),
		], $tableOptions);
		
		$this->createTable('bonus_generated', [
			'id' => $this->primaryKey(),
			'product_id' => $this->integer()->notNull(),
			'sold_critical' => $this->integer()->notNull(),
			'bonus_type' => $this->integer()->notNull(),
			'bonus_amount' => $this->decimal(8,2)->notNull(),
		], $tableOptions);
		
		$this->createTable('user_bonus', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull()->unique(),
			'total_bonus' => $this->decimal(12,2)->notNull(),
			'available_bonus' => $this->decimal(12,2)->notNull(),
			'return_bonus' => $this->decimal(12,2)->notNull(),
			'sale_bonus' => $this->decimal(12,2)->notNull(),
			'manage_bonus' => $this->decimal(12,2)->notNull(),
			'sold_count' => $this->integer()->defaultValue(0),
		], $tableOptions);
		
		$this->createTable('bonus_log', [
			'id' => $this->primaryKey(),
			'product_id' => $this->integer()->notNull(),
			'user_id' => $this->integer()->notNull()->unique(),
			'order_id' => $this->integer()->notNull(),
			'sold_critical' => $this->integer()->notNull(),
			'bonus_type' => $this->integer()->notNull(),
			'bonus_amount' => $this->decimal(8,2)->notNull(),
			'bonus_date' => $this->date()->notNull(),
		], $tableOptions);
    }

    public function down()
    {
        $this->dropColumn('order_master', 'allow_return');
		$this->dropColumn('order_master', 'sold_date');
		$this->dropColumn('order_master', 'confirm_date');
		$this->dropColumn('order_master', 'out_date');
		$this->dropColumn('order_master', 'product_id');
		
		$this->dropColumn('machine_product', 'is_default');
		
		$this->dropTable('bonus_setting');
		$this->dropTable('bonus_generated');
		$this->dropTable('user_bonus');
		$this->dropTable('bonus_log');
    }

}
