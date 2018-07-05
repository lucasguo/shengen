<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CardBuyer */

$this->title = '添加客户';
$this->params['breadcrumbs'][] = ['label' => '客户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-buyer-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
