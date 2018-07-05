<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\CardBuyer */

$this->title = $model->buyername;
$this->params['breadcrumbs'][] = ['label' => '顾客列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-buyer-view">


    <p>
        <?php if (Yii::$app->user->can('viewAllCardBuyer')) { ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该项？',
                'method' => 'post',
            ],
        ]) ?>
        <?php }?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?php
    $symptomName = $model->symptomDetail->name;
    $cardList = [];
    if ($model->symptomDetail->id == \backend\models\Symptom::OTHER_SYMPTON_ID) {
        $symptomName = $model->symptomDetail->name . ' (' . $model->other_symptom . ')';
    }
    /**
     * @var $card \backend\models\Card
     */
    foreach ($model->cards as $card) {
        $type = \backend\models\CardType::findOne($card->card_type);
        $cardList[] = $card->card_no . '(' . $type->name . ')';
    }
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'buyername',
            [
                'attribute' => 'sex',
                'value' => $model->getSexLabel(),
            ],
            'address',
            'mobile',
            [
                'attribute' => 'intro_type',
                'value' => $model->getIntroLabel(),
            ],
            'intro_name',
            [
                'attribute' => 'symptom',
                'value' => $symptomName,
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->creator->username,
                'label' => '添加人',
            ],
            'created_at:datetime',
            [
                'label' => '持有卡',
                'format' => 'raw',
                'value' => implode('<br>', $cardList),
            ],
        ],
    ]) ?>
    	</div>
    </div>
    
    <h3>理疗记录</h3>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'hidden-xs'],
                'contentOptions' => ['class' => 'hidden-xs'],
            ],
        	[
                'attribute' => 'use_datetime',
                'value' => 'useDate',
            ],
            [
                'attribute' => 'helpername',
            ],
            [
                'attribute' => 'record',
                'value' => function ($model, $key, $index, $column) {
                    return \yii\helpers\StringHelper::truncate($model->record, 10);
                }
            ],
        	[
	        	'attribute' => 'card_id',
        		'value' => 'card.card_no',
                'headerOptions' => ['class' => 'hidden-xs'],
                'contentOptions' => ['class' => 'hidden-xs'],
        	],
        ],
    ]) ?>
    	</div>
    </div>

</div>
