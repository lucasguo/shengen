<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\User;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            'mobile',
//        	'available_bonus:currency',
//        	'total_bonus:currency',
            [
                'attribute' => 'shop_id',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->shop != null) {
                        return $model->shop->name;
                    } else {
                        return "总部";
                    }
                },
                'filter' => \backend\models\DealerShop::getAllShops()
            ],
            [
             	'attribute' => 'status',
             	'value' => 'statusLabel',
            	'filter' => User::getStatusList(),
    		 ],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete} {disable} {obo}',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return $model->id != Yii::$app->user->id;
                    },
                    'delete' => function ($model, $key, $index) {
                        return $model->id != Yii::$app->user->id;
                    },
                    'disable' => function ($model, $key, $index) {
                        return $model->id != Yii::$app->user->id;
                    },
                    'obo' => function ($model, $key, $index) {
                        return $model->id != Yii::$app->user->id;
                    },
                ],
            	'buttons' => [
            		'disable' => function ($url, $model, $key) {
            			if($model->status == User::STATUS_ACTIVE) {
			                $options = [
			                    'title' => '禁用',
			                    'aria-label' => '禁用',
			                    'data-confirm' => '您确定要禁用该用户吗?',
			                    'data-method' => 'post',
			                    'data-pjax' => '0',
			                ];
			                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', Url::toRoute(['user/disable', 'id' => $model->id]), $options);
            			} elseif($model->status == User::STATUS_DELETED) {
            				$options = [
            					'title' => '启用',
            					'aria-label' => '启用',
            					'data-confirm' => '您确定要启用该用户吗?',
            					'data-method' => 'post',
            					'data-pjax' => '0',
            				];
            				return Html::a('<span class="glyphicon glyphicon-ok"></span>', Url::toRoute(['user/enable', 'id' => $model->id]), $options);
            			} else {
            				return '<a title="重发注册短信" aria-label="重发注册短信" href="#" onclick="sendSms(' . $model->id . ')"><span class="glyphicon glyphicon-envelope"></span></a>';
            			}
		            },
                    'obo' => function ($url, $model, $key) {
                        $options = [
                            'title' => '模拟登陆',
                            'aria-label' => '模拟登陆',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-log-in"></span>', Url::toRoute(['user/obo', 'id' => $model->id]), $options);
                    },
    			],
   			],
        ],
    ]); ?>
    	</div>
    </div>
</div>

<?php 
$ajaxUrl = Url::toRoute(['user/resend-sms']);
$script = <<<JS
function sendSms(id) {
	\$.ajax({
		url : '$ajaxUrl',
		data : {'id' : id},
		dataType: "json",
		error : function(ret, error) {
			alert('服务器出错，请稍后再试');
		},
		success : function(ret) {
			if(ret.status != 'error'){
				alert('注册短信已成功发送');
				window.location.reload();
			} else {
				alert('注册短信未能发送，请联系管理员后重试');
			}
		}
	});
}
JS;
$this->registerJs($script, View::POS_BEGIN);
?>
