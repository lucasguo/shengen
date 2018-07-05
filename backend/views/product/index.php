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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加产品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'product_code',
            'product_name',
            [
            	'attribute' => 'product_status',
            	'value' => 'statusLabel',
            	'filter' => MachineProduct::getStatusList(),
            ],
            // 'created_at',
            // 'updated_at',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view} {update}',
   	 		],
        ],
    ]); ?>
    </div>
    </div>
</div>
