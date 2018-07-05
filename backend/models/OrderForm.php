<?php
namespace backend\models;

use Yii;
use backend\models\OrderDetail;
use backend\models\OutOrderForm;
use backend\models\MachineIdForm;

class OrderForm extends OrderMaster
{
// 	public $machine_id;
	public $add_to_finance;
	
	public function getsoldDate()
	{
		if(!empty($this->sold_datetime)) {
			return date("Y-m-d", $this->sold_datetime);
		} else {
			return date("Y-m-d");
		}
	}
	
	public function setsoldDate($time)
	{
		$this->sold_datetime = strtotime($time);
	}
	
	/**
     * @inheritdoc
     */
    public function rules()
    {
    	$parentRules = parent::rules();
//     	$parentRules[] = [['machine_id'], 'integer'];
//     	$parentRules[] = [['machine_id'], 'required'];
//     	$parentRules[] = [['machine_id'], 'exist', 'targetClass' => MachineMaster::className(), 'targetAttribute' => 'id'];
    	$parentRules[] = [['soldDate'], 'string'];
    	$parentRules[] = [['add_to_finance'], 'safe'];
        return $parentRules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $parentLabels = parent::attributeLabels();
//         $parentLabels['machine_id'] = '售出仪器';
        $parentLabels['soldDate'] = '销售日期';
        $parentLabels['add_to_finance'] = '自动将该笔记录记入收支情况';
        return $parentLabels;
    }
    
    public function initMachines()
    {
//     	if(!empty($this->id)) {
//     		$detail = OrderDetail::findOne(['master_id' => $this->id]);
//     		if($detail) {
//     			$this->machine_id = $detail->machine_id;
//     		}
//     	}
    }
    
    /**
     * 
     * @return \backend\models\OutOrderForm
     */
    public function getOuterOrderForm()
    {
    	$form = new OutOrderForm();
    	$machineIds = [];
    	if($this->order_status == static::STATUS_CONFIRMED) {
    		for($i = 0; $i < $this->sold_count; $i ++) {
    			$machines[] = null;
    		}
    	} else {
    		$details = OrderDetail::findAll(['master_id' => $this->id]);
    		foreach ($details as $detail) {
    			$machines[] = $detail->$machine_id;
    		}
    	}
    	$form->machines = $machines;
    	return $form;
    }
}