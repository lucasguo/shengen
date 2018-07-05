<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '联系我们';
?>
<div class="body3">
    <div class="main zerogrid">
        <!-- content -->
        <article id="content">
            <div class="wrapper row">
                <section class="col-3-4">
                    <div class="wrap-col">
                        <h2 class="under">联系我们</h2>
                        <p>如果您想更深入了解我们的产品或者有意见或建议，请联系我们</p>
                        <?php $form = ActiveForm::begin(['id' => 'ContactForm']); ?>
                            <div>
<!--                                <div  class="wrapper">-->
<!--                                    <span>Your Name:</span>-->
<!--                                    <input type="text" class="input" >-->
<!--                                </div>-->
<!--                                <div  class="wrapper">-->
<!--                                    <span>Your City:</span>-->
<!--                                    <input type="text" class="input" >-->
<!--                                </div>-->
<!--                                <div  class="wrapper">-->
<!--                                    <span>Your E-mail:</span>-->
<!--                                    <input type="text" class="input" >-->
<!--                                </div>-->
<!--                                <div  class="textarea_box">-->
<!--                                    <span>Your Message:</span>-->
<!--                                    <textarea name="textarea" cols="1" rows="1"></textarea>-->
<!--                                </div>-->
                                <?= $form->field($model, 'name', ['template' => "<span>{label}</span>\n{input}\n{hint}\n{error}"])->textInput(['autofocus' => true, 'class' => 'input']) ?>

                                <?= $form->field($model, 'email', ['template' => "<span>{label}</span>\n{input}\n{hint}\n{error}"])->textInput(['class' => 'input']) ?>

                                <?= $form->field($model, 'subject', ['template' => "<span>{label}</span>\n{input}\n{hint}\n{error}"])->textInput(['class' => 'input']) ?>

                                <?= $form->field($model, 'body', ['template' => "<span>{label}</span>\n{input}\n{hint}\n{error}"])->textArea(['rows' => 6]) ?>

                                <?= $form->field($model, 'verifyCode', ['template' => "<span>{label}</span>\n{input}\n{hint}\n{error}"])->widget(Captcha::className(), [
                                    'template' => '<span class="input">{input}</span><span class="col-lg-3">{image}</span>',
                                    'class' => 'input',
                                ]) ?>
                                <?= Html::submitButton('提交', ['name' => 'contact-button']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </section>
                <section class="col-1-4">
                    <div class="wrap-col">
                        <h2 class="under">联系方式</h2>
                        <div id="address"><span>
								地址:<br><br><br>
								电话:<br>
								Email:</span>

                            <?= Yii::$app->params['contactAddress'] ?><br>
                            <?= Yii::$app->params['contactPhone'] ?><br>
                            <a href="mailto:<?= Yii::$app->params['adminEmail'] ?>" class="color2"><?= Yii::$app->params['adminEmail'] ?></a></div>
                    </div>
                </section>
            </div>

        </article>
    </div>
</div>
