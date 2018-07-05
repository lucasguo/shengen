<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\MachineProduct;


/* @var $this yii\web\View */
/* @var $model backend\models\MachineForm */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$this->title = '添加仪器';
$this->params['breadcrumbs'][] = ['label' => '仪器管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-master-create">

    <div class="box">
        <div class="box-body">

            <div class="machine-master-form">

                <?php $form = ActiveForm::begin(); ?>

                <?php
                /* @var $machine \backend\models\MachineForm */
                foreach ($machines as $key => $machine) {
                    echo $form->field($machine, "[$key]machineSn")->textInput(['disabled' => 'disabled']);
                    for ($i = 1; $i <= $machine->getCount(); $i++) {
                        $attribute = 'field' . $i;
                        echo $form->field($machine, "[$key]$attribute")->textInput();
                    }
                }
                ?>

                <div class="form-group">
                    <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>

