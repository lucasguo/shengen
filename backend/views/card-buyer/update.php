<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CardBuyer */

$this->title = '更新顾客: ' . $model->buyername;
$this->params['breadcrumbs'][] = ['label' => '顾客列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->buyername, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="card-buyer-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
