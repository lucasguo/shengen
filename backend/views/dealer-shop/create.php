<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DealerShop */

$this->title = '创建经销商门店';
$this->params['breadcrumbs'][] = ['label' => '经销商门店', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dealer-shop-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
