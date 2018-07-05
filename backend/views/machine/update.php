<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\MachineProduct;

/* @var $this yii\web\View */
/* @var $model backend\models\MachineForm */

$this->title = '修改仪器';
$this->params['breadcrumbs'][] = ['label' => '仪器管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改仪器';
?>
<div class="machine-master-update">

    <div class="box">
    	<div class="box-body">

		    <?php $form = ActiveForm::begin(); ?>
		
		    <?= $form->field($model, 'productId')->dropDownList(MachineProduct::getAllProductList(), ['disabled' => 'disabled']); ?>
		    <?= $form->field($model, 'machineSn')->textInput(['maxlength' => true]) ?>
		    <?= $form->field($model, 'machineCost')->textInput(['type' => 'number']) ?>
		
			<?php 
			for($i = 1; $i <= $model->getCount(); $i++)
			{
				$attribute = 'field' . $i;
				echo $form->field($model, $attribute)->textInput(['disabled' => 'disabled']);
			}
			?>
		
		    <?= $form->field($model, 'machineInDate')->textInput([
		    	'type' => 'date',
		    	'disabled' => 'disabled'
		    ]) ?>
		
		    <div class="form-group">
		        <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
		    </div>
		
		    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div>
