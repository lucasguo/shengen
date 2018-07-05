<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\models\MachineProduct;
use backend\models\MachineMaster;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MachineMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '仪器管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-master-index">


    <p>
	    <div class="dropdown">
		   <button type="button" class="btn dropdown-toggle btn-success" id="dropdownMenu1" 
		      data-toggle="dropdown">
		      添加仪器
		      <span class="caret"></span>
		   </button>
		   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		   <?php foreach ($products as $id=>$value) {?>
		   	  <li role="presentation">
		         <a role="menuitem" tabindex="-1" href="<?= Url::to(['create', 'productId' => $id]) ?>"><?= $value ?></a>
		      </li>
		   <?php }?>
		   </ul>
		</div>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            	'attribute' => 'product_id',
            	'value' => 'product_name',
            	'filter' => MachineProduct::getAllProductList(),
            	'label' => '产品类型',
            ],
            [
            	'attribute' => 'machine_sn',
            	'label' => '仪器编号',
            ],

            [
            	'attribute' => 'in_datetime',
            	'format' => 'date',
            	'label' => '入库时间',
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
	        	'attribute' => 'machine_status',
	        	'value' => function ($model, $key, $index, $column) {
	        		return MachineMaster::getStatusLabelFromCode($model['machine_status']);
	        	},
	        	
	        	'filter' => MachineMaster::getStatusList(),
	        	'label' => '仪器状态',
        	],
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => "{view} {update} {amend}",
            	'buttons' => [
            		'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $model['id']]), $options);
                    },
            		'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model['id']]), $options);
                    },
                    'amend' => function ($url, $model, $key) {
                        $options = [
                            'title' => '维修',
                            'aria-label' => '维修',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', Url::to(['/part/amend', 'machineId' => $model['id']]), $options);
                    },
    			],
    		],
        ],
    ]); ?>
    </div>
    </div>
</div>
