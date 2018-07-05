<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CardUsage */

$this->title = '添加理疗记录';
$this->params['breadcrumbs'][] = ['label' => '顾客列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-usage-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    	'buyerId' => $buyerId,
    ]) ?>
    	</div>
    </div>
</div>
