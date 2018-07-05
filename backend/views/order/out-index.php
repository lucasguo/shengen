<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\OrderMaster;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单出库';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-out-index">

    
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'order_sn:text:订单编号',

			'customer_name:text:顾客姓名',
            	
            
        	[
	        	'attribute' => 'sold_datetime',
	        	'format' => 'date',
	        	'label' => '订单日期',
	        	'filter'=>DateRangePicker::widget([
	        		'model' => $searchModel,
	        		'attribute' => 'daterange',
	        		'convertFormat'=>true,
	        		//'autoUpdateOnInit' => false,
	        		'pluginOptions'=>[
	        			'locale'=>[
	        				'format'=>'Y-m-d',
	        				'separator'=>' - ',
	        			],
	        			'open' => 'left',
	        		],
        		]),
        	],
        	'sold_count:integer:销售仪器数量',
            [
            	'attribute' => 'order_status',
            	'value' => function ($model, $key, $index, $column) {
        			return OrderMaster::getStatusLabelByStatus($model['order_status']);
        		},
            	'filter' => OrderMaster::getStatusList(),
            	'label' => '订单状态',
			],
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{out} {export} {finish}',
            	'visibleButtons' => [
            		'out' => function ($model, $key, $index) {
				         return $model['order_status'] == OrderMaster::STATUS_CONFIRMED && Yii::$app->user->can('manageMachine');
				     },
            		'export' => function ($model, $key, $index) {
				         return $model['order_status'] == OrderMaster::STATUS_PREPARE_OUT && Yii::$app->user->can('manageMachine');
				     },
                    'finish' => function ($model, $key, $index) {
                        return $model['order_status'] == OrderMaster::STATUS_PREPARE_OUT && Yii::$app->user->can('manageMachine');
                    },
    			],
            	'buttons' => [
            		'out' => function ($url, $model, $key) {
	            		$options = [
	            			'title' => '出库',
	            			'aria-label' => '出库',
	            			'data-pjax' => '0',
	            		];
	            		return Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', Url::to(['out', 'id' => $key]), $options);
            		},
            		'export' => function ($url, $model, $key) {
		                $options = [
		                    'title' => '导出',
		                    'aria-label' => '导出',
		                    'data-pjax' => '0',
		                ];
		                return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>', Url::to(['export', 'id' => $key]), $options);
		            },
                    'finish' => function ($url, $model, $key) {
                        $options = [
                            'title' => '安装完成',
                            'aria-label' => '安装完成',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', Url::to(['finish', 'id' => $key]), $options);
                    },
        		],
 		    ],
        ],
    ]); ?>
    </div>
    </div>
</div>
