<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */
$typeName = $model->getTypeLabel();
$this->title = $typeName . ':' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => $typeName, 'url' => ['index']];
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

</div>
