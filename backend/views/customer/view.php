<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => '我的客户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

	
    <div class="box">
    	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        	'customer_corp',
            'customer_name',
            'customer_mobile',
            'customer_address:ntext',
            'created_at:datetime',
        ],
    ]) ?>
    	</div>
    </div>
    
    <h4>维护记录</h4>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
        	[
	        	'attribute' => 'username',
        		'format' => 'text',
        		'label' => '填写人',
	        	'headerOptions' => ['class' => 'hidden-xs'],
	        	'filterOptions' => ['class' => 'hidden-xs'],
	        	'contentOptions' => ['class' => 'hidden-xs'],
        	],
        	[
	        	'attribute' => 'created_at',
        		'format' => 'datetime',
        		'label' => '填写日期',
	        	'headerOptions' => ['class' => 'hidden-xs'],
	        	'filterOptions' => ['class' => 'hidden-xs'],
	        	'contentOptions' => ['class' => 'hidden-xs'],
        	],
            'content:ntext:内容',
        ],
    ]) ?>
    	</div>
    </div>

</div>
