<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>您好，<?= Html::encode($user->username) ?>,</p>

    <p>请使用下面的链接重置密码:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    
    <p>此邮件为系统自动生成，请勿回复。</p>
</div>
