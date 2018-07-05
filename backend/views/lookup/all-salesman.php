<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\User;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modalId string */
/* @var $callback string */
/* @var $title string */

Pjax::begin([
	'id' => 'allSalesmanList',
]);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">
        选择业务员
    </h4>
</div>
<div class="modal-body">
         <?php
         $gridColumns = [
         	[
         		'class' => 'kartik\grid\RadioColumn',
         		'radioOptions' => function($model, $key, $index, $column) {
	         		return ['value' => $model->username];
         		}
         	],
         	'username',
         	'mobile',
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
		<?= $callback ?>(salesmanData);
		$("#<?= $modalId ?>").modal('hide');
	});

	var $grid = $('#<?= $gridId ?>'); 
	 
	$grid.on('grid.radiochecked', function(ev, key, val) {
		salesmanData.id = key;
		salesmanData.value = val;
	});
	 
	$grid.on('grid.radiocleared', function(ev, key, val) {
		salesmanData.id = null;
		salesmanData.value = null;
	});
});
</script>


<?php
Pjax::end();
$script = <<<JS
var salesmanData = {};
JS;

$this->registerJs ( $script );
?>
