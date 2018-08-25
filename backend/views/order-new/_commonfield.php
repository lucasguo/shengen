<?php
use kartik\select2\Select2;
use backend\models\ProductModel;
use backend\models\CustomerNew;
use backend\models\OrderNew;
use backend\models\Counterman;
?>
<?= $form->field($model, 'counterman_id')->widget(Select2::classname(), [
    'data' => Counterman::getAllCounterman(),
    'options' => ['placeholder' => '选择业务员'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'dealer_id')->widget(Select2::classname(), [
    'data' => CustomerNew::getAllDealers(),
    'options' => ['placeholder' => '选择报单人'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'hospital_id')->widget(Select2::classname(), [
    'data' => \backend\models\Hospital::getHospitalList(),
    'options' => ['placeholder' => '选择医院'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'office')->textInput() ?>

<?= $form->field($model, 'model_id')->widget(Select2::classname(), [
    'data' => ProductModel::getAllProductModels(),
    'options' => ['placeholder' => '选择型号'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model, 'orderDate')->textInput([
    'type' => 'date'
]) ?>

<?= $form->field($model, 'sell_count')->textInput() ?>