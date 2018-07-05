<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use backend\models\Finance;
use backend\modules\finance\models\ChartForm;
use miloschuman\highcharts\Highcharts;
use backend\assets\IonIconsAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\finance\models\ChartForm */
/* @var $form yii\widgets\ActiveForm */

if ($isNew) {
    $suffix = '(新)';
} else {
    $suffix = '';
}

IonIconsAsset::register($this);
$this->title = '财务报表' . $suffix;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">


		<div class="row">
            
            <div class="col-lg-4 col-xs-12">
				<div class="info-box">
	            <span class="info-box-icon bg-green"><i class="ion ion-log-in"></i></span>
		            <div class="info-box-content">
		              <span class="info-box-text">收入</span>
		              <span class="info-box-number"><?= Yii::$app->formatter->asCurrency($totalIncoming)?></span>
		            </div>
	            </div>
            </div>
            
            <div class="col-lg-4 col-xs-12">
				<div class="info-box">
	            <span class="info-box-icon bg-red"><i class="ion ion-log-out"></i></span>
		            <div class="info-box-content">
		              <span class="info-box-text">支出</span>
		              <span class="info-box-number"><?= Yii::$app->formatter->asCurrency($totalOutgoing)?></span>
		            </div>
	            </div>
            </div>
            
            <div class="col-lg-4 col-xs-12">
				<div class="info-box">
	            <span class="info-box-icon bg-aqua"><i class="ion ion-social-yen"></i></span>
		            <div class="info-box-content">
		              <span class="info-box-text">结余</span>
		              <span class="info-box-number"><?= Yii::$app->formatter->asCurrency($totalFinance)?></span>
		            </div>
	            </div>
            </div>
            
		</div>
    <?php if (!$isNew) { ?>
    <div class="row">
        <div class="col-lg-3 col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'search_type')->label('')->dropDownList(['month' => '按月', 'year' => '按年'], ['id' => 'search_type']) ?>
                    <div id="month-type">
                        <?= $form->field($model, 'month_type')->label('')->dropDownList(['current' => '当月', 'last' => '上月', 'custom' => '自定义'], ['id' => 'month_type']) ?>
                    </div>
                    <div id="year-type">
                        <?= $form->field($model, 'year_type')->label('')->dropDownList(['current' => '当年', 'last' => '去年', 'custom' => '自定义'], ['id' => 'year_type']) ?>
                    </div>
                    <div id="year">
                        <?= $form->field($model, 'year')->label('')->dropDownList($yearList) ?>
                    </div>
                    <div id="month">
                        <?= $form->field($model, 'month')->label('')->dropDownList($monthList) ?>
                    </div>
                    <?= Html::submitButton('检索', ['class' => 'btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?php
                    echo Highcharts::widget([
                        'options' => [
                            'title' => ['text' => '财务报表'],
                            'xAxis' => [
                                'categories' => $xAxisLabels,
                            ],
                            'yAxis' => [
                                'title' => ['text' => '金额(元)']
                            ],
                            'series' => [
                                ['name' => '总金额', 'data' => $financeData],
                                ['name' => '收入', 'data' => $incomingData],
                                ['name' => '支出', 'data' => $outgoingData],
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>


</div>
<?php } ?>

<?php
$scriptFunction = <<<JS
function updateSearchFormDisplay() {
	if($("#search_type").val() == 'month') {
		$("#month-type").show();
		$("#year-type").hide();
		$("#month").hide();
		$("#year").hide();
		if($("#month_type").val() == 'custom') {
			$("#month").show();
			$("#year").show();
		}
	} else {
		$("#month-type").hide();
		$("#year-type").show();
		$("#month").hide();
		$("#year").hide();
		if($("#year_type").val() == 'custom') {
			$("#year").show();
		}
	}
}
JS;

$script = <<<JS
updateSearchFormDisplay()
$("#search_type").change(function(){updateSearchFormDisplay();});
$("#month_type").change(function(){updateSearchFormDisplay();});
$("#year_type").change(function(){updateSearchFormDisplay();});
JS;

$this->registerJs($scriptFunction, View::POS_HEAD);
$this->registerJs($script);

?>
