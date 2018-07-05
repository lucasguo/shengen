<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CardType */

$this->title = '添加理疗卡类型';
$this->params['breadcrumbs'][] = ['label' => '理疗卡类型管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-type-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
