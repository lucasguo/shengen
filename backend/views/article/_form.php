<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_top')->checkbox() ?>

    <?= $form->field($model, 'category')->dropDownList(\common\models\Article::getCategoryList()) ?>


    <?= $form->field($model, 'content')->widget(\backend\widgets\CKEditor::className()) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$copyUrl = \yii\helpers\Url::to(['article/copy']);
$script = <<<JS
$('#copy').click(function() {
    url = $('#article-source').val();
    if (url.length > 0 && url.match(/(http(s)?)/gi)) {
        $.ajax({
			url : '$copyUrl',
			data : {'url' : url},
			dataType : "json",
			error : function(ret, error) {
				alert(ret.responseText);
			},
			success : function(ret) {
				
				if(ret.status=='ok'){
					CKEDITOR.instances[0].setData(ret.content);
				}else{
					alert('无法获取内容');
					return;
				}
			}
		});
    } else {
        alert('无效的网址');
    }
});
JS;
$this->registerJs($script);
?>

