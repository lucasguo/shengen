<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\PartType;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PartTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modalId string */
/* @var $callback string */
/* @var $title string */

Pjax::begin([
	'id' => 'partTypeList',
]);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">
        选择配件类型
    </h4>
</div>
<div class="modal-body">
         <?php
         $gridColumns = [
         	[
         		'class' => 'kartik\grid\RadioColumn',
         		'radioOptions' => function($model, $key, $index, $column) {
	         		return ['value' => $model->part_name];
         		}
         	],
         	'part_name'
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
		<?= $callback ?>(partTypeData);
		$("#<?= $modalId ?>").modal('hide');
	});

	var $grid = $('#<?= $gridId ?>'); 
	 
	$grid.on('grid.radiochecked', function(ev, key, val) {
	    partTypeData.id = key;
		partTypeData.value = val;
	});
	 
	$grid.on('grid.radiocleared', function(ev, key, val) {
	    partTypeData.id = null;
		partTypeData.value = null;
	});
});
</script>


<?php
Pjax::end();
$script = <<<JS
var partTypeData = {};
JS;

$this->registerJs ( $script );
?>
