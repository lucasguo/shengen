<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\MachineForm;
use backend\models\MachineProduct;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineForm */

$this->title = '查看仪器';
$this->params['breadcrumbs'][] = ['label' => '仪器管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-master-view">


    <p>
        <?= Html::a('修改', ['update', 'id' => $machineId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('维修', ['/part/amend', 'machineId' => $machineId], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="box">
    	<div class="box-body">
    <?php
    $productList = MachineProduct::getAllProductList();
    $baseAttr = [
        	[
        		'attribute' => 'productId',
        		'value' => $productList[$model->productId],
    		],
            'machineSn',
            'machineCost',
            'machineInDate:date',
        ];
    $extraAttr = [];
    for($i = 1; $i <= $model->getCount(); $i ++) {
    	$extraAttr[] = 'field' . $i;
    }
    echo DetailView::widget([
        'model' => $model,
        'attributes' => ArrayHelper::merge($baseAttr, $extraAttr),
    ]) ?>
    </div>
    </div>

    <?php
    echo $this->render('/part/_amend-record',[
        'dataProvider' => $dataProvider,
    ]);
    ?>

</div>
