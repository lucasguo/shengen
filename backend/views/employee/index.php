<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加员工', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
            <?php $auth = Yii::$app->authManager; ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'mobile',
            [
                'value' => function ($model, $key, $index, $column) use ($auth) {
                    $roles = $auth->getRolesByUser($model->id);
                    foreach ($roles as $role) {
                        if ($role->name == 'dealer') {
                            return '管理员';
                        }
                    }
                    return '员工';
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                         return $key != Yii::$app->user->id;
                    },
                    'delete' => function ($model, $key, $index) {
                        return $key != Yii::$app->user->id;
                    }
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>
</div>
