<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Hospital */

$this->title = '创建医院';
$this->params['breadcrumbs'][] = ['label' => '医院管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospital-create">
    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>
</div>
