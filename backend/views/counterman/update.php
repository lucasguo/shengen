<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Counterman */

$this->title = '更新业务员: ' . $model->counterman_name;
$this->params['breadcrumbs'][] = ['label' => '业务员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->counterman_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="counterman-update">
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
