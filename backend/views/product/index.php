<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\MachineProduct;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MachineProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-product-index">

    <p>
        <?= Html::a('添加产品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'headerRowOptions' => ['class' => 'hidden-xs'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'hidden-xs'],
            ],

            // 'id',
            [
                'attribute' => 'product_code',
                'contentOptions' => ['class' => 'hidden-xs'],
            ],
            'product_name',
            [
            	'attribute' => 'product_status',
            	'value' => 'statusLabel',
                'contentOptions' => ['class' => 'hidden-xs'],
            	'filter' => MachineProduct::getStatusList(),
            ],
            // 'created_at',
            // 'updated_at',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('【明细】', $url);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('【修改】', $url);
                    },
                ],
   	 		],
        ],
    ]); ?>
    </div>
    </div>
</div>