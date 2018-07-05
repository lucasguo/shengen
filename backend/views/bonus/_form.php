<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\BonusSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bonus-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'single_price')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'single_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'once_return')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_bonus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manage_bonus')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'yearly_bonus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level_limit')->textInput()->hint('此层数包括最底下的只买过仪器但没有发展团队的一层') ?>

    <?= $form->field($model, 'return_day_limit')->textInput()->hint('经过该时间段后销售提成才会记入相关人员账目中') ?>

    <div class="form-group text-center">
        <?= Html::submitButton('保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::button('测试收入支出', ['id' => 'text-btn', 'class' => 'btn btn-default', 'data-toggle' => "modal", 'data-target' => "#myModal" ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="modal fade type-danger bootstrap-dialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title bootstrap-dialog-title" id="myModalLabel">测试收入支出</h4>
            </div>
            <div class="modal-body">
	            <div id="modal-info">
		            <p>测试基于未修改前的数值，如要测试修改后的值请先保存。</p>
		            <p><b>确定进行测试吗？</b></p>
	            </div>

				<div id="modal-progress" style="display: none;">
					<p>测试数据生成中，请等待。</p>
					<div class="progress active">
						<div class="progress-bar progress-bar-primary progress-bar-striped"
							role="progressbar" aria-valuenow="40" aria-valuemin="0"
							aria-valuemax="100" style="width: 100%">
						</div>
					</div>
				</div>
				
				<div id="modal-result" style="display: none;">
<!-- 					<table class="table table-bordered"> -->
<!-- 						<thead> -->
<!-- 							<tr> -->
<!-- 								<th>总销售台数</th> -->
<!-- 								<th>总营收(元)</th> -->
<!-- 								<th>总支出(元)</th> -->
<!-- 								<th>仪器总成本(元)</th> -->
<!-- 								<th>销售立返总额(元)</th> -->
<!-- 								<th>销售奖总额(元)</th> -->
<!-- 								<th>管理将总额(元)</th> -->
<!-- 								<th>差额(元)</th> -->
<!-- 							</tr> -->
<!-- 						</thead> -->
<!-- 						<tbody> -->
<!-- 							<tr> -->
<!-- 								<td id='totalCount'>0</td> -->
<!-- 								<td id='totalIncoming'>0</td> -->
<!-- 								<td id='totalOutgoing'>0</td> -->
<!-- 								<td id='totalCost'>0</td> -->
<!-- 								<td id='totalReturnBonus'>0</td> -->
<!-- 								<td id='totalSaleBonus'>0</td> -->
<!-- 								<td id='totalManageBonus'>0</td> -->
<!-- 								<td id='totalDiff'>0</td> -->
<!-- 							</tr> -->
<!-- 						</tbody> -->
<!-- 					</table> -->
					<table class="table table-bordered">
						<tr>
							<th>总销售台数</th>
							<td id='totalCount'>0</td>
						<tr>
						<tr>
							<th>总营收(元)</th>
							<td id='totalIncoming'>0</td>
						<tr>
						<tr>
							<th>总支出(元)</th>
							<td id='totalOutgoing'>0</td>
						<tr>
						<tr>
							<th>仪器总成本(元)</th>
							<td id='totalCost'>0</td>
						<tr>
						<tr>
							<th>销售立返总额(元)</th>
							<td id='totalReturnBonus'>0</td>
						<tr>
						<tr>
							<th>销售奖总额(元)</th>
							<td id='totalSaleBonus'>0</td>
						<tr>
						<tr>
							<th>管理奖总额(元)</th>
							<td id='totalManageBonus'>0</td>
						<tr>
						<tr>
							<th>年终奖总额(元)</th>
							<td id='totalYearly'>0</td>
						<tr>
						<tr>
							<th>差额(元)</th>
							<td id='totalDiff'>0</td>
						<tr>
					</table>
				</div>
				
				<div id="modal-failed" style="display: none;">
					<p>发生错误。</p>
					<p id="error-msg"></p>
				</div>

			</div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> 取消</button>
            	<button type="button" class="btn btn-warning" id="delete-btn"><span class="glyphicon glyphicon-play"></span> 开始测试</button>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php 
$url = Url::to(['bonus/simulate']);
$script = <<<JS
$('#delete-btn').click(function(){
	$('#modal-info').hide();
	$('#modal-progress').show();
	$('.modal-footer').hide();
	$.ajax({
        url: '$url',
        type: 'GET',
        dataType: 'json',
    }).success(function(data){
		$('#modal-progress').hide();
		$('#modal-result').show();
		$('#totalIncoming').html(data.totalIncoming);
		$('#totalOutgoing').html('-' + data.totalOutgoing);
		$('#totalCost').html('-' + data.totalCost);
		$('#totalReturnBonus').html('-' + data.totalReturnBonus);
		$('#totalSaleBonus').html('-' + data.totalSaleBonus);
		$('#totalManageBonus').html('-' + data.totalManageBonus);
		$('#totalYearly').html('-' + data.totalYearly);
		$('#totalDiff').html(data.totalDiff);
		$('#totalCount').html(data.totalCount);
    }).fail(function( data ){
		$('#modal-progress').hide();
		$('#error-msg').html(data);
		$('#modal-failed').show();

    });
});
JS;
$this->registerJs($script);
?>
