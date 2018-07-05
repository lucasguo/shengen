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

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>

