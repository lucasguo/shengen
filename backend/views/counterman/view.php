<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Counterman */

$this->title = $model->counterman_name;
$this->params['breadcrumbs'][] = ['label' => '业务员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counterman-view">


    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
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
            'counterman_name',
            [
                'attribute' => 'city_id',
                'value' => $model->city->name,
            ],
        ],
    ]) ?>
    	</div>
    </div>

</div>
