<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\OrderNew;
use backend\models\ProductModel;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */

$this->title = '查看备案单';
$this->params['breadcrumbs'][] = ['label' => '备案单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-new-view">


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
    <?php
    $abstractAttr = [
        [
            'attribute' => 'counterman_id',
            'value' => $model->counterman ? $model->counterman->counterman_name : null,
        ],
        [
            'attribute' => 'dealer_id',
            'value' => $model->dealer ? $model->dealer->customer_name : null,
        ],
        [
            'attribute' => 'hospital_id',
            'value' => $model->hospital ? $model->hospital->hospital_name : null,
        ],
        'office',
        [
            'attribute' => 'model_id',
            'value' => ProductModel::getFullProductModelName($model->model_id),
        ],
        'orderDate',
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
    ];
    $fullAttr = [
        [
            'attribute' => 'counterman_id',
            'value' => $model->counterman ? $model->counterman->counterman_name : null,
        ],
        [
            'attribute' => 'dealer_id',
            'value' => $model->dealer ? $model->dealer->customer_name : null,
        ],
        [
            'attribute' => 'hospital_id',
            'value' => $model->hospital ? $model->hospital->hospital_name : null,
        ],
        'office',
        [
            'attribute' => 'model_id',
            'value' => ProductModel::getFullProductModelName($model->model_id),
        ],
        'orderDate',
        [
            'attribute' => 'sell_amount',
            'format' => 'currency',
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
    ];
    if ($model->order_status == OrderNew::STATUS_INIT) {
        $attr = $abstractAttr;
    } else {
        $attr = $fullAttr;
    }
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attr,
    ]) ?>

    	</div>
    </div>
    <?php if ($orgModel != null) { ?>
        <h4>原始备案单信息</h4>
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $orgModel,
                    'attributes' => $abstractAttr,
                ]) ?>

            </div>
        </div>
    <?php } ?>
</div>
