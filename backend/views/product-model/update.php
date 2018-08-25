<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductModel */

$this->title = '更新产品型号: ' . $model->model_name;
$this->params['breadcrumbs'][] = ['label' => '产品型号', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="product-model-update">
    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
