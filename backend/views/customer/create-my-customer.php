<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MyCustomerForm */
/* @var $form ActiveForm */
$this->title = '添加客户';
$this->params['breadcrumbs'][] = ['label' => '我的客户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create-my-customer">

    <div class="box">
    	<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
    
   
    
    
    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mobile')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'bankaccount')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'bankname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'beneficiary')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'auto_convert')->checkbox() ?>
    
    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>
    
        <div class="form-group text-center">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div><!-- customer-create-my-customer -->
