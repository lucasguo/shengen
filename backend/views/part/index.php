<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\PartType;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '配件管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            	'attribute' => 'part_type',
            	'value' => 'partType.part_name',
            	'label' => '配件类型',
            	'filter' => PartType::getAllPartTypeList(),
            ],
            'part_sn',
            [
                'attribute' => 'status',
                'value' => 'statusLabel',
                'filter' => \backend\models\Part::getStatusList(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {amend}",
                'visibleButtons' => [
                    'amend' => function ($model, $key, $index) {
                        return $model->status == \backend\models\Part::STATUS_NORMAL;
                    },
                ],
                'buttons' => [
                    'amend' => function ($url, $model, $key) {
                        $options = [
                            'title' => '维修',
                            'aria-label' => '维修',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', Url::to(['amend', 'partId' => $key]), $options);
                    },
                ],
            ],
        ],
    ]); ?>
    	</div>
    </div>
</div>
