<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\models\Finance;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if ($isNew) {
    $suffix = '(新)';
} else {
    $suffix = '';
}

$this->title = '收支情况' . $suffix;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

    <p>
        <div class="dropdown">
		   <button type="button" class="btn dropdown-toggle btn-success" id="dropdownMenu1" 
		      data-toggle="dropdown">
		      填写收支
		      <span class="caret"></span>
		   </button>
		   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		   	  <li role="presentation">
		         <a role="menuitem" tabindex="-1" href="<?= Url::to(['create', 'type' => 1, 'isNew' => $isNew]) ?>">收入</a>
		         <a role="menuitem" tabindex="-1" href="<?= Url::to(['create', 'type' => -1, 'isNew' => $isNew]) ?>">支出</a>
		      </li>
		   </ul>
		</div>
    </p>
    
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
		    	'attribute' => 'type',
            	'value' => 'typeLabel',	
            	'filter' => Finance::getTypeList(),
		    ],
            [
            	'attribute' => 'amount',
            	'format' => 'currency',
            	'filter' => $searchModel->renderAmountRangeFilter(),
            ],
            //'userid',
            'content:ntext',
        	'occur_date:date',
            // 'status',
            // 'relate_table',
            // 'relate_id',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'visibleButtons' => [
            		'update' => \Yii::$app->user->can('updateFinance'),
            		'delete' => \Yii::$app->user->can('updateFinance'),
    			],
                'urlCreator' => function ($action, $model, $key, $index, $column) use ($isNew) {
                    return Url::toRoute([$column->controller ? $column->controller . '/' . $action : $action, 'id' => $key, 'isNew' => $isNew]);
                }
    		],
        ],
    ]); ?>
    </div>
    </div>
</div>
