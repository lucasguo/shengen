<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */

$this->title = '更新备案单';
$this->params['breadcrumbs'][] = ['label' => '备案单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '查看备案单', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="order-new-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
