<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\OrderMaster;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-index">



    <?php if(Yii::$app->user->can("addCustomer")) {?>
    <p>
        <?= Html::a('新建订单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php }?>
    
    <div class="box">
    	<div class="box-body">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
        	[
        		'attribute' => 'sold_amount',
        		'format' => 'currency',
        		'label' => '订单总额',
        		'filter' => $searchModel->renderAmountRangeFilter(),
        	],
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
            	'template' => '{view} {update} {confirm}',
            	'visibleButtons' => [
            		'update' => function ($model, $key, $index) {
				         return Yii::$app->user->can('updateOrder');
				     },
            		'confirm' => function ($model, $key, $index) {
				         return $model['order_status'] == OrderMaster::STATUS_COLLECTED && Yii::$app->user->can('updateOrder');
				     },
    			],
            	'buttons' => [
            		'confirm' => function ($url, $model, $key) {
		                $options = [
		                    'title' => Yii::t('yii', '确认'),
		                    'aria-label' => Yii::t('yii', '确认'),
		                	'data-confirm' => Yii::t('yii', '确认该笔订单已收到钱款?'),
		                    'data-pjax' => '0',
		                ];
		                return Html::a('<span class="glyphicon glyphicon-ok"></span>', Url::to(['confirm', 'id' => $key]), $options);
		            },
        		],
 		    ],
        ],
    ]); ?>
    </div>
    </div>
</div>
