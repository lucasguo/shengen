<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use backend\models\CustomerNew;

$this->title = '欢迎使用圣恩管理系统';
?>
<div class="site-index">
    <?= Html::a(CustomerNew::getTypeLabelFromCode(CustomerNew::TYPE_COMPANY), ['/customer-new/index', 'type' => CustomerNew::TYPE_COMPANY], ['class' => "btn btn-block btn-primary btn-lg"])?>
    <?= Html::a(CustomerNew::getTypeLabelFromCode(CustomerNew::TYPE_HOSPITAL), ['/customer-new/index', 'type' => CustomerNew::TYPE_HOSPITAL], ['class' => "btn btn-block btn-primary btn-lg"])?>
    <?= Html::a(CustomerNew::getTypeLabelFromCode(CustomerNew::TYPE_PATIENT), ['/customer-new/index', 'type' => CustomerNew::TYPE_PATIENT], ['class' => "btn btn-block btn-primary btn-lg"])?>
    <?= Html::a('备案管理', ['/order-new/index'], ['class' => "btn btn-block btn-primary btn-lg"])?>
</div>
