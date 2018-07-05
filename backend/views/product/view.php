<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineProduct */
/* @var $form backend\models\ProductForm */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-product-view">


    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_code',
            'product_name',
        	[
	        	'attribute' => 'product_status',
	        	'value' => $model->statusLabel,
        	],
        ],
    ]) ?>
    <h4>组成配件</h4>
    <?= DetailView::widget([
        'model' => $form,
        'attributes' => [
        	[
	        	'attribute' => 'partType1',
	        	'value' => $form->getPartTypeName(1),
        	],
        	[
	        	'attribute' => 'partType2',
	        	'value' => $form->getPartTypeName(2),
        	],
        	[
	        	'attribute' => 'partType3',
	        	'value' => $form->getPartTypeName(3),
        	],
        	[
	        	'attribute' => 'partType4',
	        	'value' => $form->getPartTypeName(4),
        	],
        ],
    ]) ?>

</div>
