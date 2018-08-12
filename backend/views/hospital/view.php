<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Hospital */

$this->title = $model->hospital_name;
$this->params['breadcrumbs'][] = ['label' => '医院管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospital-view">


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
            'hospital_name',
            [
                'attribute' => 'hospital_city',
                'value' => $model->cityRegion->name,
            ],
            'comment:ntext',
            'created_at:datetime',
        ],
    ]) ?>
    	</div>
    </div>

</div>
