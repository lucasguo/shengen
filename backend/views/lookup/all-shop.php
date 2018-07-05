<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\User;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DealerShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modalId string */
/* @var $callback string */
/* @var $title string */

Pjax::begin([
	'id' => 'allShopList',
]);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">
        选择门店
    </h4>
</div>
<div class="modal-body">
         <?php
         $gridColumns = [
         	[
         		'class' => 'kartik\grid\RadioColumn',
         		'radioOptions' => function($model, $key, $index, $column) {
	         		return ['value' => $model->name];
         		}
         	],
         	'name',
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
		<?= $callback ?>(shopData);
		$("#<?= $modalId ?>").modal('hide');
	});

	var $grid = $('#<?= $gridId ?>'); 
	 
	$grid.on('grid.radiochecked', function(ev, key, val) {
		shopData.id = key;
        shopData.value = val;
	});
	 
	$grid.on('grid.radiocleared', function(ev, key, val) {
        shopData.id = null;
        shopData.value = null;
	});
});
</script>


<?php
Pjax::end();
$script = <<<JS
var shopData = {};
JS;

$this->registerJs ( $script );
?>
