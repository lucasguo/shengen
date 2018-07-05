<?php

use yii\db\Migration;
use backend\models\MachineProduct;
use backend\models\BonusSetting;
use common\models\User;
use backend\helpers\BonusHelper;
use yii\db\Schema;

class m160918_034608_init_bonus extends Migration
{
//     public function up()
//     {
//     }

    public function down()
    {
    	$this->alterColumn('bonus_setting', 'created_by', Schema::TYPE_INTEGER . ' NOT NULL');
    	$this->alterColumn('bonus_setting', 'updated_by', Schema::TYPE_INTEGER . ' NOT NULL');
    	$this->dropColumn('user', 'customer_id');
    	$this->dropColumn('user', 'up_id');
    	$this->dropColumn('user_bonus', 'product_id');
        $this->truncateTable('bonus_setting');
        $this->truncateTable('bonus_generated');
    }

    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    	echo '    > Setting default product ...';
    	$defaultProduct = MachineProduct::find()->one();
    	$defaultProduct->is_default = 1;
    	$defaultProduct->save();
    	echo " done.\n";
    	
    	$this->alterColumn('bonus_setting', 'created_by', Schema::TYPE_INTEGER . ' NULL');
    	$this->alterColumn('bonus_setting', 'updated_by', Schema::TYPE_INTEGER . ' NULL');
    	$this->alterColumn('bonus_generated', 'bonus_amount', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL');
    	$this->alterColumn('bonus_log', 'bonus_amount', Schema::TYPE_DECIMAL . '(12, 2) NOT NULL');
    	
    	$this->addColumn('user', 'customer_id', Schema::TYPE_INTEGER . ' NULL');
    	$this->addColumn('user', 'up_id', Schema::TYPE_INTEGER . ' NULL');
    	
    	$this->addColumn('user_bonus', 'product_id', Schema::TYPE_INTEGER . ' NOT NULL');
    	
    	echo '    > Inserting default bonus ...';
    	$bonus = new BonusSetting();
    	$bonus->single_price = 12800;
    	$bonus->level_limit = 12;
    	$bonus->manage_bonus = 10;
    	$bonus->sale_bonus = 2.5;
    	$bonus->once_return = 3800;
    	$bonus->return_day_limit = 7;
    	$bonus->product_id = $defaultProduct->id;
    	// use this to pass blameablebehavior
//     	$user = User::find()->one();
//     	\Yii::$app->user->login($user, 0);
    	if(!$bonus->save()) {
    		echo "\n";
    		foreach ($bonus->getErrors() as $attribute => $errors) {
				echo "<" . $attribute . ">\n";
				foreach ($errors as $error)
				{
					echo "  " . iconv("utf-8", "gbk", $error) . "\n";
				}
				echo "\n";
			}
    		return false;
    	}
//     	\Yii::$app->user->logout();
    	echo " done.\n";
    	
    	echo '    > generating bonus details ...';
    	BonusHelper::generateBonus($bonus);
    	echo " done.\n";
    }

    /*
    public function safeDown()
    {
    }
    */
}
