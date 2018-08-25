<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\ProductModel;
use backend\models\CustomerNew;
use backend\models\Counterman;
use backend\models\OrderNew;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderNew */

$this->title = '备案单成交';
$this->params['breadcrumbs'][] = ['label' => '备案单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '查看备案单', 'url' => ['view', 'id' => $model->org_order_id]];
$this->params['breadcrumbs'][] = '成交';
?>
<div class="order-new-update">
    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
            <div class="order-new-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $this->render('_commonfield', [
                    'form' => $form,
                    'model' => $model,
                ]) ?>

                <?= $form->field($model, 'sell_amount')->textInput() ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('成交', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
    	</div>
    </div>

</div>
