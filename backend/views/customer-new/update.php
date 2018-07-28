<?php

use yii\helpers\Html;
use backend\models\CustomerNew;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */

$typeName = $model->getTypeLabel();
$this->title = '更新' . $typeName . ': ' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => $typeName, 'url' => ['index', 'type' => $model->customer_type]];
$this->params['breadcrumbs'][] = ['label' => $model->customer_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="customer-new-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
