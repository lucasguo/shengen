<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MeetingRecord */

$this->title = 'Update Meeting Record: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Meeting Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="meeting-record-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
