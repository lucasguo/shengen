<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\CustomerNew;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerNewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$typeName = CustomerNew::getTypeLabelFromCode($type);
$this->title = $typeName . '资料';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-new-index">

    <?= Html::button('搜索开关', ['class' => 'btn btn-primary', 'id' => 'search_toggle', 'style' => 'margin-bottom: 5px']) ?>
    <div id="search_container" style="display: none">
    <?php  echo $this->render('_search', ['model' => $searchModel, 'type' => $type]); ?>
    </div>
    <p>
        <?= Html::a('创建' . $typeName, ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'customer_name',
            [
                'attribute' => 'customer_company',
                'label' =>  CustomerNew::getTypeCompanyLabelFromCode($type)
            ],
            'customer_job',
            'customer_mobile',
            'comment:ntext',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {add}',
                'buttons' => [
                    'add' => function ($url, $model, $key) {
                        $options = [
                            'title' => '添加维护记录',
                            'aria-label' => '添加维护记录',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['maintain', 'id' => $key]), $options);
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
