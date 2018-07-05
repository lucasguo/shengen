<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Part */

$this->title = '配件:' . $model->part_sn;
$this->params['breadcrumbs'][] = ['label' => '配件管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-view">

    <p>
        <?php
        if ($canFix) {
            echo Html::a('维修', ['amend', 'partId' => $model->id], ['class' => 'btn btn-primary']);
        }
        ?>
    </p>

    <div class="box">
        <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'part_type',
                'value' => $model->partType->part_name,
            ],
            'part_sn',
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel(),
            ],
        ],
    ]) ?>
        </div>
    </div>

    <?php
    echo $this->render('_amend-record',[
        'dataProvider' => $dataProvider,
    ]);
    ?>

</div>
