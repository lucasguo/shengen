<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DealerShop */

$this->title = '更新经销商门店: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '经销商门店', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="dealer-shop-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
