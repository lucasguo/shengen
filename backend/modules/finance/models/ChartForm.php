<?php
namespace backend\modules\finance\models;

use Yii;
use yii\base\Model;

class ChartForm extends Model
{
	public $search_type;
	public $year_type;
	public $month_type;
	public $year;
	public $month;
	
	public function rules()
	{
		return [
			['search_type', 'default', 'value' => 'month'],
			['month_type', 'default', 'value' => 'current'],
			['search_type', 'in', 'range' => ['year', 'month']],
			[['year_type', 'month_type'], 'in', 'range' => ['current', 'last', 'custom']],
			[['year', 'month'], 'integer'],
		];
	}
}