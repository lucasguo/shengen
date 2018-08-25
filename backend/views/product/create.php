<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MachineProduct */

$this->title = '添加产品';
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-product-create">
    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="box">
    	<div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    	'prodForm' => $prodForm,
    ]) ?>
    	</div>
    </div>

</div>
