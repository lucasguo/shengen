<?php
namespace tests\codeception\backend\fixtures;

use yii\test\ActiveFixture;

class OrderFixture extends ActiveFixture
{
	public $modelClass = "backend\models\OrderMaster";
	
	public function unload()
	{
		parent::unload();
		$this->resetTable();
	}
}