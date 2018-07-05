<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DealerShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '经销商门店管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dealer-shop-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加经销商门店', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <div class="box">
    	<div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div>
