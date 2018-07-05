<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MeetingRecord */

$this->title = '上传内部文件';
$this->params['breadcrumbs'][] = ['label' => '内部文件', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meeting-record-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
