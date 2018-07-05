<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\ProductPartType;

class ProductForm extends Model
{
	public $partType1;
	public $partType2;
	public $partType3;
	public $partType4;
	
	public function rules()
	{
        return [
            [['partType1', 'partType2', 'partType3', 'partType4'], 'integer'],
            [['partType1', 'partType2', 'partType3', 'partType4'], 'exist', 'targetClass' => PartType::className(), 'targetAttribute' => 'id'],
        ];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'partType1' => '组成配件(1)',
			'partType2' => '组成配件(2)',
			'partType3' => '组成配件(3)',
			'partType4' => '组成配件(4)',
		];
	}
	
	public function getPartTypeName($index)
	{
		$ret = "";
		if(is_numeric($index) && $index >= 1 && $index <= 4) {
			$attr = "partType" . $index;
			if(!empty($this->$attr)) {
				$type = PartType::findOne($this->$attr);
				if($type) {
					$ret = $type->part_name;
				}
			}
		}
		return $ret;
	}
	
	public function save($productId)
	{
		ProductPartType::deleteAll(['product_id' => $productId]);
		for($i = 1; $i <= 4; $i ++) {
			$attr = "partType" . $i;
			if(!empty($this->$attr)) {
				$ppt = new ProductPartType();
				$ppt->product_id = $productId;
				$ppt->part_type_id = $this->$attr;
				$ppt->save();
			}
		}
	}
}