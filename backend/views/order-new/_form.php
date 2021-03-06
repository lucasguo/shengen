<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\models\ProductModel;
use backend\models\CustomerNew;
use backend\models\OrderNew;
use backend\models\Counterman;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-new-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_commonfield', [
        'form' => $form,
        'model' => $model,
    ]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
