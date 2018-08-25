<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineProduct */

$this->title = '修改产品: ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改产品';
?>
<div class="machine-product-update">
    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    	'prodForm' => $prodForm,
    ]) ?>
    	</div>
    </div>

</div>
