<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Finance */

if ($isNew) {
    $suffix = '(新)';
} else {
    $suffix = '';
}

$this->title = '填写收支';
$this->params['breadcrumbs'][] = ['label' => '收支情况' . $suffix, 'url' => ['index', 'isNew' => $isNew]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-create">

	<div class="box">
	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    	'type' => $type,
        'isNew' => $isNew,
    ]) ?>
    </div></div>

</div>
