<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Card;

/* @var $this yii\web\View */
/* @var $model backend\models\CardUsage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-usage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'card_id')->dropDownList(Card::getBuyerAvailableCards($buyerId)) ?>

    <?= $form->field($model, 'useDate')->textInput(['type' => 'date', 'value' => date('Y-m-d'),]); ?>

    <?= $form->field($model, 'record')->textInput(['maxlength' => true])->label('理疗记录（用户治疗后感觉）'); ?>

    <?= $form->field($model, 'helpername')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
