<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DealerShop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '经销商门店', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dealer-shop-view">


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
            [
                'attribute' => 'user_id',
                'value' => function ($model, $widget) {
                    if ($model->opener != null) {
                        return $model->opener->username;
                    } else {
                        return null;
                    }
                }
            ],
            'name',
            [
                'attribute' => 'province',
                'value' => $model->provinceRegion->name,
            ],
            [
                'attribute' => 'city',
                'value' => $model->cityRegion->name,
            ],
            [
                'attribute' => 'region',
                'value' => $model->regionRegion->name,
            ],
            'address',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
        ],
    ]) ?>
    	</div>
    </div>

    <?= $this->render('/card-buyer/shop-info', [
        'data' => $data,
    ]) ?>

</div>
