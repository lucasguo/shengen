<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Symptom */

$this->title = '更新症状: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '症状管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="symptom-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
