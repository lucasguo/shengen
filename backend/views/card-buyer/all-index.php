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

    <div class="box">
        <div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',

//            'sex',
//            'address',
            [
                'attribute' => 'shop_id',
                'value' => 'shop.name',
                'filter' => \backend\models\DealerShop::getAllShops(),
            ],
            'buyername',
//            'shop_id',
//             'mobile',
//            [
//                'attribute' => 'intro_type',
//                'value' => 'introLabel',
//                'filter' => \backend\models\CardBuyer::getIntroList(),
//            ],
//            'intro_name',
            // 'urgentperson',
            // 'urgentmobile',
            // 'symptom',
//             'created_at:datetime',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
    </div>
</div>
