<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Symptom */

$this->title = '添加症状';
$this->params['breadcrumbs'][] = ['label' => '症状管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="symptom-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
