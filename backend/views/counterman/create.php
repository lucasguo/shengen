<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Counterman */

$this->title = '创建业务员';
$this->params['breadcrumbs'][] = ['label' => 'Countermen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counterman-create">
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
