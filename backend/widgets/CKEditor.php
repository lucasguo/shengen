<?php
namespace backend\widgets;

use backend\assets\CKConfigAsset;
use yii\widgets\InputWidget;
use dosamigos\ckeditor\CKEditorAsset;
use yii\helpers\Html;

class CKEditor extends InputWidget
{
	public function init()
	{
		CKConfigAsset::register($this->view);
		CKEditorAsset::register($this->view);
		parent::init();
	}
	
	public function run()
	{
		if ($this->hasModel()) {
			echo Html::activeTextarea($this->model, $this->attribute, ['id' => $this->getId()]);
		} else {
			echo Html::textarea($this->name, '', ['id' => $this->getId()]);
		}
		$this->view->registerJs('$("#'. $this->getId() . '").ckeditor(' . CKConfigAsset::CONFIG_NAME . ')');
	}
}