<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class CustomerMaintainNewForm extends Model
{
	public $content;
	public $add_alert;
	public $alert_date;
	public $alert_time;
	public $alert_content;

	const TIME_LIST = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
	
	public function rules()
	{
		return [
			[['content', 'alert_date', 'alert_content'], 'string'],
			['content', 'required'],
			['add_alert', 'in', 'range' => ['0', '1']],
			[
				['alert_date'], 
				'required',
				'when' => function ($model) { return $model->add_alert == 1; }, 
				'whenClient' => "function (attribute, value) { return $('#add_alert').is(':checked'); }"
			],
            [
                ['alert_time'],
                'in',
                'range' => self::TIME_LIST,
                'when' => function ($model) { return $model->add_alert == 1; },
                'whenClient' => "function (attribute, value) { return $('#add_alert').is(':checked'); }"
            ],
			['alert_date', 'verifyFuture'],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'content' => '维护记录',
			'add_alert' => '添加下次维护提醒',
			'alert_date' => '下次提醒日期',
            'alert_time' => '下次提醒时间点',
			'alert_content' => '提醒内容',
		];
	}
	
	public function verifyFuture()
	{
		if($this->add_alert === '0')
		{
			return;
		}
		$today = strtotime('today');
		$inputted = strtotime($this->alert_date);
		if($inputted < $today)
		{
			$this->addError('alert_date', '提醒日期不能是过去的日期');
		}
	}
}