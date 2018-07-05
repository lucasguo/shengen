<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CardUsage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Card Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-usage-view">


    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该项？',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'card_id',
            'record',
            'helpername',
            'use_datetime:datetime',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>
    	</div>
    </div>

</div>
