<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Finance */
if ($isNew) {
    $suffix = '(新)';
} else {
    $suffix = '';
}

$this->title = '更新收支' . $suffix;
$this->params['breadcrumbs'][] = ['label' => '收支情况' . $suffix, 'url' => ['index', 'isNew' => $isNew]];
$this->params['breadcrumbs'][] = ['label' => '查看明细' . $suffix, 'url' => ['view', 'id' => $model->id, 'isNew' => $isNew]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-update">

   	<div class="box">
	<div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    	'type' => $model->type,
        'isNew' => $isNew,
    ]) ?>
    </div></div>

</div>
