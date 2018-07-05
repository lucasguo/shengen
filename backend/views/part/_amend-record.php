<?php
use kartik\grid\GridView;
?>

<h3>维修记录</h3>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'contentOptions' => ['class' => 'hidden-xs'],
                ],
                'created_at:datetime',
                [
                    'attribute' => 'before_part_id',
                    'value' => function ($model, $key, $index, $column) {
                        /* @var $model \backend\models\AmendRecord */
                        if ($model->ament_type == \backend\models\AmendRecord::TYPE_FIX) {
                            if ($model->before_part_id == \backend\models\AmendRecord::PART_OTHER) {
                                return \backend\models\AmendRecord::PART_OTHER_NAME;
                            } else {
                                return $model->oldPart->partType->part_name . ': ' . $model->oldPart->part_sn;
                            }
                        } else {
                            return $model->oldPart->partType->part_name . ': <br>' . $model->oldPart->part_sn . ' -> ' . $model->newPart->part_sn;
                        }
                    },
                    'format' => 'raw',
                ],
                'comment:ntext',
            ],
        ]) ?>
    </div>
</div>