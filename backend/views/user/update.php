<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改用户: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-update">


    <?= $this->render('_form', [
        'model' => $model,
        'shopName' => $shopName,
    ]) ?>

</div>
