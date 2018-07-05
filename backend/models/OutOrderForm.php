<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class OutOrderForm extends Model
{
	public $machines;
	public $errorHook;
	
	public function attributeLabels()
	{
		return [
			'machines' => '仪器编号',
		];
	}
	
	public function rules()
	{
		return [
			['machines', 'verifyRequired'],
			['machines', 'verifyInteger'],
			['machines', 'verifyDuplicate'],
			['machines', 'verifyExist'],
		];
	}
	
	public function verifyRequired()
	{
		foreach ($this->machines as $machine) {
			if(empty($machine)) {
				$this->addError('errorHook', '有仪器未选择');
				return;
			}
		}
	}
	
	public function verifyInteger()
	{
		foreach ($this->machines as $machine) {
			if(!is_numeric($machine)) {
				$this->addError('errorHook', '有非法的仪器编号');
				return;
			}
		}
	}
	
	public function verifyDuplicate()
	{
		if(count(array_unique($this->machines))<count($this->machines))
		{
		    $this->addError('errorHook', '有重复的仪器被选中');
		}
	}
	
	public function verifyExist()
	{
		// expensive validation, run only other validation passed.
		if($this->hasErrors())
		{
			return;
		}
		foreach ($this->machines as $machine) {
			$exist = MachineMaster::findOne(['id' => $machine, 'machine_status' => MachineMaster::STATUS_WAREHOUSED]);
			if($exist == null) {
				$this->addError('errorHook', '选中了不存在或已出库的仪器');
				return;
			}
		}
	}
}