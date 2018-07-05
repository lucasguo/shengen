<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PartType */

$this->title = '创建配件类型';
$this->params['breadcrumbs'][] = ['label' => '配件类型管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-type-create">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
    </div>

</div>
