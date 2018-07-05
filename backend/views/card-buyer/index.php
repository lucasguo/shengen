<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CardBuyerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '顾客列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-buyer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加顾客', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'hidden-xs'],
                'filterOptions' => ['class' => 'hidden-xs'],
                'contentOptions' => ['class' => 'hidden-xs'],
            ],

//            'id',
            [
                'attribute' => 'buyername',
                'filterOptions' => ['class' => 'hidden-xs'],
            ],
//            'sex',
//            'address',
//            'shop_id',
             [
                 'attribute' => 'mobile',
                 'filterOptions' => ['class' => 'hidden-xs'],
             ],
            // 'urgentperson',
            // 'urgentmobile',
            // 'symptom',
             [
                 'attribute' => 'created_at',
                 'format' => 'datetime',
                 'headerOptions' => ['class' => 'hidden-xs'],
                 'filterOptions' => ['class' => 'hidden-xs'],
                 'contentOptions' => ['class' => 'hidden-xs'],
             ],
             [
             	'attribute' => 'cardlist',
             	'label' => '卡号',
             	'value' => function ($model, $key, $index, $column){
             		return StringHelper::truncate($model['cardlist'], 16);
             	},
                 'headerOptions' => ['class' => 'hidden-xs'],
                 'filterOptions' => ['class' => 'hidden-xs'],
                 'contentOptions' => ['class' => 'hidden-xs'],
             ],
             [
             	'attribute' => 'times',
             	'label' => '剩余次数',
             	'value' => function ($model, $key, $index, $column){
             		if ($model['times'] > 5) {
             			return $model['times'] . '次';
             		} else {
             			return $model['times'] . '次 ' . Html::a('[办新卡]', ['add-card', 'id' => $key]);
             		}
             	},
             	'format' => 'raw',
                'filterOptions' => ['class' => 'hidden-xs'],
             ],
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {add}',
                'buttons' => [
                    'add' => function ($url, $model, $key) {
                        $options = [
                            'title' => '添加理疗记录',
                            'aria-label' => '添加理疗记录',
                            'data-pjax' => '0',
                        ];
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-plus"]);
                        $url = \yii\helpers\Url::to(['add-usage', 'buyerId' => $key]);
                        return Html::a($icon, $url, $options);
                    },
                ],
                'filterOptions' => ['class' => 'hidden-xs'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
    </div>
</div>
