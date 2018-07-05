<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\MeetingRecord;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MeetingRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '内部文件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meeting-record-index">


    <p>
        <?= Html::a('上传内部文件', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created_at:datetime:上传日期',
            'username:text:上传者',
        	'topic:ntext:主题',
			[
				'attribute' => 'file_type',
				'filter' => MeetingRecord::getFileTypeList(),
				'value' => function ($model, $key, $index, $column) {
					return MeetingRecord::getFileTypeLabel($model['file_type']);
				},
				'label' => '类型',
        	],
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{download}',
            	'buttons' => [
				    'download' => function ($url, $model, $key) {
				        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', ['download', 'id' => $key]);
				    },
				],
    		],
        ],
    ]); ?>
    	</div>
    </div>
</div>
