<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductModel */

$this->title = $model->model_name;
$this->params['breadcrumbs'][] = ['label' => '产品型号', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-view">


    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                [
                    'attribute' => 'product_id',
                    'value' => $model->product->product_name,
                ],
            'model_name',
        ],
    ]) ?>
    	</div>
    </div>

</div>
