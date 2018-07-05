<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BonusSetting */

$this->title = 'Create Bonus Setting';
$this->params['breadcrumbs'][] = ['label' => 'Bonus Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-setting-create">
    <div class="box">
    	<div class="box-body">
    		<div class="row">
				<div class="col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    			</div>
    		</div>
    	</div>
    </div>
</div>
