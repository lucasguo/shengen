<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BonusSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bonus Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bonus Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'single_price',
            'once_return',
            'sale_bonus',
            'manage_bonus',
            // 'level_limit',
            // 'return_day_limit',
            // 'product_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
