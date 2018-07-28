<?php

use yii\helpers\Html;
use backend\models\CustomerNew;


/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */

$typeName = CustomerNew::getTypeLabelFromCode($type);
$this->title = '创建' . $typeName;
$this->params['breadcrumbs'][] = ['label' => $typeName, 'url' => ['index', 'type' => $type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-new-create">
    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type
    ]) ?>
    	</div>
    </div>
</div>
