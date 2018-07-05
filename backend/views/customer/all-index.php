<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\models\Customer;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '客户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">
    
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            	'class' => 'yii\grid\SerialColumn',
            	'filterOptions' => ['class' => 'hidden-xs'],
            ],
        	[
        		'attribute' => 'created_at',
        		'label' => '登记日期',
        		'format' => 'datetime',
        		'filterOptions' => ['class' => 'hidden-xs'],
        	],
            [
            	'attribute' => 'customer_name',
            	'label' => '客户姓名',
            	'filterOptions' => ['class' => 'hidden-xs'],
            ],
        	[
	        	'attribute' => 'customer_mobile',
	        	'label' => '客户联系电话',
        		'filterOptions' => ['class' => 'hidden-xs'],
        	],
        	[
	        	'attribute' => 'customer_corp',
	        	'label' => '客户公司',
        		'filterOptions' => ['class' => 'hidden-xs'],
        	],
        	[
        		'attribute' => 'belongto',
        		'value' => 'username',
        		'label' => '归属',
        		'filter' => User::getAllSalesman(),
    		],
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}',
            	'filterOptions' => ['class' => 'hidden-xs'],
            	'buttons' => [
            		'update' => function ($url, $model, $key) {
            			$options = [
            				'title' => Yii::t('yii', 'Update'),
            				'aria-label' => Yii::t('yii', 'Update'),
            				'data-pjax' => '0',
            			];
            			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model['id']]), $options);
            		},
        		],
    		],
        ],
    ]); ?>
    	</div>
    </div>
</div>
