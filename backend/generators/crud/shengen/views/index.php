<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

<?php if(!empty($generator->searchModelClass)): ?>
    <div id="search_container" style="display: none">
<?= "    <?php " ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
<?php endif; ?>

    <p>
        <?= "<?= " ?>Html::button('搜索开关', ['class' => 'btn btn-primary', 'id' => 'search_toggle']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
<?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'headerRowOptions' => ['class' => 'hidden-xs'],
        <?=  "'columns' => [\n"; ?>
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'hidden-xs'],
            ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

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
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
</div>
</div>
</div>
<?= "<?php\n" ?>
$toggleScript = <<<JS
$( "#search_toggle" ).click(function() {
  $( "#search_container" ).toggle( "fast");
});
JS;
$this->registerJs($toggleScript);
