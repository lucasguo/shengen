<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

    <?= $form->field($model, 'role')->dropDownList(\backend\controllers\EmployeeController::getAvailableRoles())
        ->hint('管理员有权限管理其他员工以及查看修改所有顾客详情') ?>

    <div class="form-group text-center">
        <?= Html::submitButton(empty($model->userId) ? '创建' : '更新', ['class' => empty($model->userId) ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
