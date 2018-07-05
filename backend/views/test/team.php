<?php
use backend\assets\OrgChartAsset;
use backend\assets\TeamAsset;
use backend\helpers\CustomerNodeHelper;

/* @var $this yii\web\View */
/* @var $leftUser common\models\User */
/* @var $rightUser common\models\User */

OrgChartAsset::register($this);
TeamAsset::register($this);
$this->title = '查看团队';
$this->params ['breadcrumbs'] [] = ['label' => '模拟测试', 'url' => ['index']];;
$this->params ['breadcrumbs'] [] = $this->title;
?>

<ul id="team">
<?php CustomerNodeHelper::renderNode($tree, true); ?>
</ul>
<div class="box">
    <div class="box-body">
    	<p class="intro-node">最多显示5层结构，如需查看更多，请点击下层用户名以查看下层用户的团队图</p>
		<div id="chart-container"></div>
	</div>
</div>

<?php 
$script = <<<JS
$("#team").jOrgChart({'chartElement': '#chart-container'});
JS;
$this->registerJs($script);
?>