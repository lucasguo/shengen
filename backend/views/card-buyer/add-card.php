<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\CardBuyer */

$this->title = '客户办卡：' . $buyername;
$this->params['breadcrumbs'][] = ['label' => '客户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-buyer-create">
    <div class="box">
    	<div class="box-body">
		    <div class="card-buyer-form">
		
		    <?php $form = ActiveForm::begin(); ?>
	
		    <?php
	        echo $form->field($model, 'cardType')->dropDownList(\backend\models\CardType::getAllCardTypes());
	        echo $form->field($model, 'cardNo')->textInput(['maxlength' => true]);
		    ?>
		
		    <div class="form-group text-center">
		        <?= Html::submitButton('添加', ['class' => 'btn btn-success']) ?>
		    </div>
		
		    <?php ActiveForm::end(); ?>
		
		</div>
    	</div>
    </div>
</div>
