<?php
namespace backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * LookupInput is one read-only text input with one magnifying glass and one hidden input that hold the true value
 * Once the magnifying glass is clicked, one modal dialog will show up filling with the content of url specific in 'popupUrl'.
 * After choosing one value from modal dialog, 'jsCallback' will be called.
 * Be sure jsCallback has contain one parameter named data
 * text input and hidden input's ids can be separate defined in 'textId' and 'hiddenId'. If not defined, the default value is 
 * text input : <model name>-<attribute name>-text
 * hidden input : <model name>-<attribute name>-hidden
 * text input's init value can be provided by 'textValue'
 * button's content also can be provided through 'buttonContent'
 * buttonContent's default value is "<span class="glyphicon glyphicon-zoom-in"></span>"
 * 
 * 
 * The usage is as below
 * 
 * ```php
 * echo LookupInput::widget([
 * 	'popupUrl' => ['lookup/customer'],
 * 	'jsCallback' => 'updateCustomer'
 * ])
 * ```
 * 
 * Then use js code as below to update the interface
 * ```
 * function updateCustomer(data) {
 * 	$("#customer_input").val(data.id);
 * }
 * ```
 * 
 * @author Lucas
 *
 */
class PopupInput extends InputWidget
{
	/**
	 * @var string|array the url that display in popup window. Required
	 */
	public $popupUrl;
	
	/**
	 * function name without parameter part
	 * @var string|JsExpression the function to be called then the ok button on popup window is clicked.
	 */
	public $jsCallback;
	
	/**
	 * The ID of the read only text input
	 * default value is <model name>-<attribute name>-text. This id can be used in js.
	 * @var string
	 */
	public $textId;
	
	/**
	 * The ID of the hidden input that hold the true value
	 * default value is <model name>-<attribute name>-hidden.
	 * @var string
	 */
	public $hiddenId;

	
	/**
	 * the html code to render button
	 * @var string
	 */
	public $buttonContent;
	
	/**
	 * init value displayed in read-only text field
	 * @var string
	 */
	public $textValue;
	
	private $buttonId;
	private $modalId;
	
	/**
	 * init the widget
	 * @throws InvalidConfigException if popupUrl is not set
	 */
	public function init()
	{
		parent::init();
		if(empty($this->popupUrl)) {
			throw new InvalidConfigException('popupUrl must be set');
		}
		if(empty($this->textId)) {
			$this->textId = Html::getInputId($this->model, $this->attribute) . "-text";
		}
		if(empty($this->hiddenId)) {
			$this->hiddenId = Html::getInputId($this->model, $this->attribute) . "-hidden";
		}
		if(empty($this->buttonContent)) {
			$this->buttonContent = "<span class='glyphicon glyphicon-zoom-in'></span>";
		}
		if(empty($this->textValue)) {
			$this->textValue = "";
		}
		$this->buttonId = Html::getInputId($this->model, $this->attribute) . "-btn";
		$this->modalId = Html::getInputId($this->model, $this->attribute) . "-modal";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \yii\base\Widget::run()
	 */
	public function run()
	{
		$this->registerClientScript();
		echo Html::beginTag("div", ["class" => "input-group form-group"]);
		echo Html::textInput(null, $this->textValue, [
			"id" => $this->textId,
			"class" => "form-control", 
			"disabled" => "disabled"
		]);
		echo Html::beginTag("div", ["class" => "input-group-btn"]);
		if(is_array($this->popupUrl)) {
			$this->popupUrl[] = ["modalId" => $this->modalId, "jsCallback" => $this->jsCallback];
			$popupUrl = Url::to($this->popupUrl);
		} else {
			$popupUrl = Url::to([$this->popupUrl, "modalId" => $this->modalId, "jsCallback" => $this->jsCallback]);
		}
		echo Html::a($this->buttonContent, $popupUrl, [
			"class" => "btn btn-default",
			"data-toggle" => "modal",
			"data-target" => "#" . $this->modalId,
		]);
		echo Html::endTag("div");
		echo Html::activeHiddenInput($this->model, $this->attribute, ["id" => $this->hiddenId]);
		echo Html::endTag("div");

	}
	
	/**
	 * Registers the needed client script.
	 */
	public function registerClientScript()
	{
		$modalId = $this->modalId;
		
		$modalHtml = <<<HTML
<div class="modal fade" id="$modalId" tabindex="-1" role="dialog" \
   aria-labelledby="myModalLabel" aria-hidden="true"> \
   <div class="modal-dialog"> \
      <div class="modal-content"> \
      <div class="progress progress-striped active"> \
		   <div class="progress-bar progress-bar-success" role="progressbar" \
		      aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" \
		      style="width: 100%;"> \
		   </div> \
		</div> \
      </div><!-- /.modal-content --> \
</div><!-- /.modal -->
HTML;
		
		$script = <<<JS
		\$('$modalHtml').appendTo('body');
		\$("#$modalId").on("hidden.bs.modal", function() {  
		    \$(this).removeData("bs.modal");  
		});  
JS;
		$this->getView()->registerJs($script);
		

	}
}