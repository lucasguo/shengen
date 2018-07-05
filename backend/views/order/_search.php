<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-master-search form-inline">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    	'class' => 'form-inline',
    ]); ?>

    
    <?= $form->field($model, 'machine_sn')->label('仪器编号') ?>

    <div class="form-group">
    	<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    	<div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
