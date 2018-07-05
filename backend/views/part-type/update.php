<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PartType */

$this->title = '修改配件类型: ' . $model->part_name;
$this->params['breadcrumbs'][] = ['label' => '配件类型管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->part_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改配件类型';
?>
<div class="part-type-update">

        <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
    </div>

</div>
