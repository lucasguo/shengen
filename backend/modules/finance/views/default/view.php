<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Finance */
if ($isNew) {
    $suffix = '(新)';
} else {
    $suffix = '';
}
$this->title = '查看明细';
$this->params['breadcrumbs'][] = ['label' => '收支情况' . $suffix, 'url' => ['index', 'isNew' => $isNew]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-view">


    <p>
    <?php if(Yii::$app->user->can('upateFinance')) {?>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'isNew' => $isNew], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'isNew' => $isNew], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该笔记录？',
                'method' => 'post',
            ],
        ]) ?>
    <?php } ?>
    </p>

    <div class="box"><div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            	'attribute' => 'type',
            	'value' => $model->getTypeLabel(),
            ],
            'amount:currency',
            [
            	'attribute' => 'userid',
            	'value' => empty($model->userid) ? '无' : User::findOne($model->userid)->username,
    		],
            'content:ntext',
        	'occur_date:date',
            'created_at:datetime',
        ],
    ]) ?>
    </div></div>

</div>
