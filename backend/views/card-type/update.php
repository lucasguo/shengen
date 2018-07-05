<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CardType */

$this->title = '更新理疗卡类型: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '理疗卡类型管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card-type-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
