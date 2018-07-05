<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '创建用户';
$this->params['breadcrumbs'][] = ['label' => '管理用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
        'shopName' => $shopName,
    ]) ?>

</div>
