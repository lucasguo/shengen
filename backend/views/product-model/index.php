
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品型号';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-index">

    <div id="search_container" style="display: none">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <p>
        <?= Html::button('搜索开关', ['class' => 'btn btn-primary', 'id' => 'search_toggle']) ?>
        <?= Html::a('创建产品型号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
                'attribute' => 'product_id',
                'value' => 'product.product_name',
            ],
            'model_name',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
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
