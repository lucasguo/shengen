<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CardUsage */

$this->title = 'Update Card Usage: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Card Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card-usage-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
