<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Part;
use backend\models\MachineMaster;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class MachineForm extends Model
{
    public $machineId;
	public $productId;
	public $machineSn;
	public $machineCost;
	public $machineInDate;
	protected $_fieldcount;
	public $field1;
	protected $_field1Label;
	public $field2;
	protected $_field2Label;
	public $field3;
	protected $_field3Label;
	public $field4;
	protected $_field4Label;

	public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), ['update']);
    }

    public function rules()
	{
		if(empty($this->_fieldcount)) {
			throw new InvalidConfigException("updateFields() must be called before use");
		}
		$fields = [];
		for($i = 1; $i <= $this->_fieldcount; $i ++)
		{
			$fields[] = 'field' . $i;
		}
		$baseRules = [
			[['productId', 'machineSn', 'machineCost'], 'required', 'on' => Model::SCENARIO_DEFAULT],
			[['productId'], 'integer', 'on' => Model::SCENARIO_DEFAULT],
			[['machineCost'], 'number', 'on' => Model::SCENARIO_DEFAULT],
			[['machineSn', 'machineInDate'], 'string', 'max' => 255, 'on' => Model::SCENARIO_DEFAULT],
			[['machineSn'], 'unique', 'targetClass' => MachineMaster::className(), 'targetAttribute' => 'machine_sn', 'on' => Model::SCENARIO_DEFAULT],
		];
		if(count($fields) > 0) {
			$extraRules = [
				[$fields, 'required', 'on' => [Model::SCENARIO_DEFAULT, 'update']],
				[$fields, 'unique', 'targetClass' => Part::className(), 'targetAttribute' => 'part_sn', 'on' => [Model::SCENARIO_DEFAULT, 'update']],
			];
		} else {
			$extraRules = [];
		}
		return ArrayHelper::merge($baseRules, $extraRules);
	}
	
	public function attributeLabels()
	{
		return [
			'productId' => '产品类型',
			'machineSn' => '仪器编号',
			'machineCost' => '成本价',
			'machineInDate' => '入库日期',
			'field1' => $this->_field1Label,
			'field2' => $this->_field2Label,
			'field3' => $this->_field3Label,
			'field4' => $this->_field4Label,
		];
	}
	
	public function updateFields($labels)
	{
		$this->_fieldcount = count($labels);
		for($i = 0; $i < $this->_fieldcount; $i++)
		{
			$fieldname = "_field" . ($i + 1) . "Label";
			$this->$fieldname = $labels[$i] . '编号';
		}
	}
	
	public function getCount()
	{
		return $this->_fieldcount;
	}
	
	/**
	 * @param MachineMaster
	 */
	public function fromMachineMaster($master)
	{
		$this->productId = $master->product_id;
		$this->machineCost = $master->machine_cost;
		$this->machineSn = $master->machine_sn;
		$this->machineInDate = $master->in_datetime;
		$this->machineId = $master->id;
	}
	
	public function toMachineMaster()
	{
		$master = new MachineMaster();
		$master->machine_cost = $this->machineCost;
		$master->machine_sn = $this->machineSn;
		$master->in_datetime = $this->machineInDate;
		$master->product_id = $this->productId;
		if ($this->machineId) {
		    $master->id = $this->machineId;
		    $master->setIsNewRecord(false);
        }
		return $master;
	}
	
}