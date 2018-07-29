<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */
$typeName = $model->getTypeLabel();
$this->title = $typeName . ':' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => $typeName, 'url' => ['index', 'type' => $model->customer_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-new-view">


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
            'customer_name',
            'customer_mobile',
            [
                'attribute' => 'customer_company',
                'label' => \backend\models\CustomerNew::getTypeCompanyLabelFromCode($model->customer_type)
            ],
            'customer_job',
            'comment:ntext',
            [
                'attribute' => 'created_at',
                'format' => 'datetime'
            ],
        ],
    ]) ?>
    	</div>
    </div>

    <h4>维护记录</h4>
    <p>
        <?= Html::a('添加维护记录', ['maintain', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'username',
                        'format' => 'text',
                        'label' => '填写人',
                        'headerOptions' => ['class' => 'hidden-xs'],
                        'filterOptions' => ['class' => 'hidden-xs'],
                        'contentOptions' => ['class' => 'hidden-xs'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => '填写日期',
                        'headerOptions' => ['class' => 'hidden-xs'],
                        'filterOptions' => ['class' => 'hidden-xs'],
                        'contentOptions' => ['class' => 'hidden-xs'],
                    ],
                    'content:ntext:内容',
                ],
            ]) ?>
        </div>
    </div>

</div>
