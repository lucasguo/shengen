<?php
namespace tests\codeception\backend\fixtures;

use yii\test\ActiveFixture;

class CustomerFixture extends ActiveFixture
{
	public $modelClass = "backend\models\Customer";
	
	public function unload()
	{
		parent::unload();
		$this->resetTable();
	}
}