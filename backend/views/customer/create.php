<?php


/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = '添加客户';
$this->params['breadcrumbs'][] = ['label' => '我的客户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
