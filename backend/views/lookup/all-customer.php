<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\User;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AllCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modalId string */
/* @var $callback string */
/* @var $title string */

Pjax::begin([
	'id' => 'allCustomerList',
]);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">
        选择客户
    </h4>
</div>
<div class="modal-body">
         <?php
         $gridColumns = [
         	[
         		'class' => 'kartik\grid\RadioColumn',
         		'radioOptions' => function($model, $key, $index, $column) {
	         		return ['value' => $model['customer_name']];
         		}
         	],
         	'customer_name:text:客户姓名',
         	'customer_mobile:text:客户联系方式',
         ];
         
         $gridId = $modalId . "-grid";
         
         echo GridView::widget ( [
         	'dataProvider' => $dataProvider,
         	'filterModel' => $searchModel,
         	'columns' => $gridColumns,
         	'export' => false,
         	'id' => $gridId,
         ] );
?>
         <div class="modal-footer">
	<?php 
         $btnId = $modalId . "-ok";
		echo Html::button ( "确定", [ 
			'class' => 'btn btn-success',
			'id' => $btnId 
		] );
		
		?>
         </div>

</div>

<script>
$(function(){
	$("#<?= $btnId ?>").on('click', function(){
		<?= $callback ?>(customerData);
		$("#<?= $modalId ?>").modal('hide');
	});

	var $grid = $('#<?= $gridId ?>'); 
	 
	$grid.on('grid.radiochecked', function(ev, key, val) {
		customerData.id = key;
		customerData.value = val;
	});
	 
	$grid.on('grid.radiocleared', function(ev, key, val) {
		customerData.id = null;
		customerData.value = null;
	});
});
</script>


<?php
Pjax::end();
$script = <<<JS
var customerData = {};
JS;

$this->registerJs ( $script );
?>
