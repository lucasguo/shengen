<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SymptomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '症状管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="symptom-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加症状', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'created_at:datetime',
//            'updated_at',
//            'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' =>  function ($model, $key, $index) {
                        return $model->id !== \backend\models\Symptom::OTHER_SYMPTON_ID;
                    },
                    'update' =>  function ($model, $key, $index) {
                        return $model->id !== \backend\models\Symptom::OTHER_SYMPTON_ID;
                    },
                    'delete' =>  function ($model, $key, $index) {
                        return $model->id !== \backend\models\Symptom::OTHER_SYMPTON_ID;
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>
</div>
