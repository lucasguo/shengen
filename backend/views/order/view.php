<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Customer;
use backend\models\MachineMaster;
use backend\models\OrderMaster;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderForm */

$this->title = $model->order_sn;
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-view">


	<?php if(Yii::$app->user->can('updateOrder')) {?>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
		if($model->order_status == OrderMaster::STATUS_COLLECTED) {
	        echo Html::a('删除', ['delete', 'id' => $model->id], [
	            'class' => 'btn btn-danger',
	            'data' => [
	                'confirm' => '确定删除该订单?',
	                'method' => 'post',
	            ],
	        ]); 
		}?>
    </p>
    <?php }?>

    <div class="box">
    	<div class="box-body">
    <?php
    $customerName = Customer::findOne($model->customer_id)->customer_name;
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
	        	'attribute' => 'customer_id',
	        	'value' => $customerName,
        	],
            'sold_count',
            'sold_amount',
            'sold_datetime:date',
            [
	        	'attribute' => 'order_status',
	        	'value' => $model->statusLabel,
        	],
            'warranty_in_month',
        	[
	        	'label' => '仪器编号',
	        	'value' => $machineSn,
        	],
        ],
    ]); 
    ?>
    	</div>
    </div>

</div>
