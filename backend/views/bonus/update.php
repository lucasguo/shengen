<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BonusSetting */

// $this->title = 'Update Bonus Setting: ' . $model->id;
$this->title = '提成设置';
// $this->params['breadcrumbs'][] = ['label' => 'Bonus Settings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="bonus-setting-update">

    <div class="box">
    	<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
