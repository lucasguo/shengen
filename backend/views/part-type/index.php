<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PartTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '配件类型管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建配件类型', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'part_name',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update}',
    		],
        ],
    ]); ?>
    </div>
    </div>
</div>
