<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductModel */

$this->title = '创建产品型号';
$this->params['breadcrumbs'][] = ['label' => '产品型号', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-create">
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
