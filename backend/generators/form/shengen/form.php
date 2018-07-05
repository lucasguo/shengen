<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= $generator->modelClass ?> */
/* @var $form ActiveForm */
<?= "?>" ?>

<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">

    <div class="box">
    	<div class="box-body">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

    <?php foreach ($generator->getModelAttributes() as $attribute): ?>
    <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
    <?php endforeach; ?>

        <div class="form-group text-center">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('提交') ?>, ['class' => 'btn btn-primary']) ?>
        </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
    	</div>
    </div>

</div><!-- <?= str_replace('/', '-', trim($generator->viewName, '-')) ?> -->
