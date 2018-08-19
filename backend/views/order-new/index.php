<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\OrderNew;
use backend\models\ProductModel;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderNewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '备案单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-new-index">

    <div id="search_container" style="display: none">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <p>
        <?= Html::button('搜索开关', ['class' => 'btn btn-primary', 'id' => 'search_toggle']) ?>
        <?= Html::a('创建备案单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    状态: <span class="order-init">备案</span>&nbsp;<span class="order-deal">成交</span>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'headerRowOptions' => ['class' => 'hidden-xs'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'hidden-xs'],
            ],
            [
                'attribute' => 'model_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->order_status == OrderNew::STATUS_INIT) {
                        $class = 'order-init';
                    } else {
                        $class = 'order-deal';
                    }
                    return Html::tag('span', ProductModel::getFullProductModelName($model->model_id), ['class' => $class]);
                },
            ],
            [
                'attribute' => 'customer_id',
                'value' => 'customer.customer_name',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete} {deal}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('【明细】', $url);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('【修改】', $url);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        ];
                        return Html::a('【删除】', $url, $options);
                    },
                    'deal' => function ($url, $model, $key) {
                        if ($model->order_status == \backend\models\OrderNew::STATUS_INIT) {
                            return Html::a('【成交】', \yii\helpers\Url::to(['deal', 'id' => $key]));
                        } else {
                            return "";
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
</div>
</div>
<?php
$toggleScript = <<<JS
$( "#search_toggle" ).click(function() {
  $( "#search_container" ).toggle( "fast");
});
JS;
$this->registerJs($toggleScript);
