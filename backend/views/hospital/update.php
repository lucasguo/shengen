<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Hospital */

$this->title = '更新医院: ' . $model->hospital_name;
$this->params['breadcrumbs'][] = ['label' => '医院管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hospital_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="hospital-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
