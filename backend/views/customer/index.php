<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\Customer;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的客户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <p>
        <?= Html::a('添加客户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            	'class' => 'yii\grid\SerialColumn',
            	'headerOptions' => ['class' => 'hidden-xs'],
            	'filterOptions' => ['class' => 'hidden-xs'],
            	'contentOptions' => ['class' => 'hidden-xs'],
    		],
        	[
	        	'attribute' => 'customer_type',
        		'filter' => Customer::getTypeList(),
        		'value' => 'typeLabel',
	        	'headerOptions' => ['class' => 'hidden-xs'],
	        	'filterOptions' => ['class' => 'hidden-xs'],
	        	'contentOptions' => ['class' => 'hidden-xs'],
        	],
        	[
	        	'attribute' => 'customer_corp',
        		'value' => function ($model, $key, $index, $column) {
        			return StringHelper::truncate($model['customer_corp'], 10);
        		},
        	],
            'customer_name',

            [
            	'attribute' => 'customer_mobile',
            	'headerOptions' => ['class' => 'hidden-xs'],
            	'filterOptions' => ['class' => 'hidden-xs'],
            	'contentOptions' => ['class' => 'hidden-xs'],
            ],
            [
            	'attribute' => 'customer_address',
            	'format' => 'ntext',
            	'headerOptions' => ['class' => 'hidden-xs'],
            	'filterOptions' => ['class' => 'hidden-xs'],
            	'contentOptions' => ['class' => 'hidden-xs'],
            	
            ],
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view} {add}',
            	'buttons' => [
            		'add' => function ($url, $model, $key) {
	            		$options = [
	            			'title' => '添加维护记录',
	            			'aria-label' => '添加维护记录',
	            			'data-pjax' => '0',
	            		];
	            		return Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['maintain', 'id' => $key]), $options);
            		},
            	],
    		],
        ],
    ]); ?>
    	</div>
    </div>
</div>
