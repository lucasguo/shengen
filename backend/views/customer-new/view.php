<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\models\CustomerNew */
$typeName = $model->getTypeLabel();
$this->title = $typeName . ':' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => $typeName, 'url' => ['index', 'type' => $model->customer_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-new-view">


    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该项？',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
    	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => \yii\helpers\ArrayHelper::merge(\yii\helpers\ArrayHelper::merge(
             [
                 'customer_name',
                 'customer_mobile',
                 [
                    'attribute' => 'customer_company',
                    'label' => \backend\models\CustomerNew::getTypeCompanyLabelFromCode($model->customer_type)
                 ],
             ],
            $model->customer_type == \backend\models\CustomerNew::TYPE_PATIENT ? [] : ['customer_job']
          ),[
                [
                    'attribute' => 'hospital_id',
                    'value' => $model->customer_type == \backend\models\CustomerNew::TYPE_COMPANY ? $model->getHospitals() : $model->getHospital(),
                    'label' => '关联医院'
                ],
                'comment:ntext',
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime'
                ],
            ]
        ),
    ]) ?>
        </div>
    </div>
    <?php if ($model->customer_type == \backend\models\CustomerNew::TYPE_PATIENT) { ?>
        <h4>患者信息</h4>
    <div class="box">
        <div class="box-body">
                <?= DetailView::widget([
                    'model' => $extend,
                    'attributes' => [
                        [
                            'attribute' => 'gender',
                            'value' => \backend\models\CustomerNewExtend::getGenderList()[$extend->gender],
                        ],
                        'age',
                        'diagnosis',
                        'disease_course',
                        'treat_plan',
                        [
                            'attribute' => 'doctor_id',
                            'value' => $extend->getDoctorName(),
                        ],
                    ],
                ]) ?>

    	</div>
    </div>
    <?php } ?>

    <h4>维护记录</h4>
    <p>
        <?= Html::a('添加维护记录', ['maintain', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-fixed'],
                'headerRowOptions' => ['class' => 'hidden-xs'],
                'columns' => [
                    [
                        'attribute' => 'username',
                        'format' => 'text',
                        'label' => '填写人',
                        'filterOptions' => ['class' => 'hidden-xs'],
                        'contentOptions' => ['class' => 'hidden-xs'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => '填写日期',
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'ntext',
                        'label' => '维护内容',
                        'contentOptions' => ['class' => 'wrap-content'],
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
