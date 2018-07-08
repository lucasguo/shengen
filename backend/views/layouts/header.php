<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini"></span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
			
            <ul class="nav navbar-nav">
				<li class="user user-menu dropdown">
					<a data-toggle="dropdown" href="#">欢迎您，<?=\Yii::$app->user->identity->username ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<div class="user-footer">

		                    <a class="btn btn-default btn-flat" href="<?=Url::to(['site/update-password']) ?>">修改密码</a>

		                    <a class="btn btn-default btn-flat" href="<?=Url::to(['site/update-email']) ?>">修改资料</a>

                            <?php if (\common\models\User::isObo()) {
                                echo '<a class="btn btn-default btn-flat" href="' . Url::to(['site/exit-obo']) . '">退出模拟登陆</a>';
                            } ?>

		                    <a class="btn btn-default btn-flat" href="<?=Url::to(['site/logout']) ?>">退出登录</a>

		                </div>
	                </ul>
                </li>
                
                <li class="dropdown notifications-menu">
                	<?php 
                	$alertCount = Yii::$app->alert->getMyTodayAlertCount();
                	if(empty($alertCount)) {
                		$alertCount = 0;
                	}
                	?>
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		              <i class="fa fa-bell-o"></i>
		              <?php if($alertCount > 0) {?>
		              <span class="label label-warning"><?=$alertCount?></span>
		              <?php }?>
		            </a>
		            <ul class="dropdown-menu">
		              <?php if($alertCount > 0) {?>
		              <li class="header">今天有<?=$alertCount?>个通知</li>
		              <li>
		                <!-- inner menu: contains the actual data -->
		                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
		                <?php 
		                $alerts = Yii::$app->alert->getMyTodayAlerts();
		                foreach ($alerts as $alert) {
		                	echo "<li>";
		                	echo "<a href=\"#\">";
		                	echo "<i class=\"fa fa-warning text-yellow\"></i>";
		                	echo $alert->content;
		                	echo "</a>";
		                	echo "</li>";
		                }
		                ?>
		                </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
		              </li>
		              <?php } else {?>
		              <li class="header">今天没有通知事项</li>
		              <?php }?>
		            </ul>
		          </li>
                
            </ul>
        </div>
    </nav>
</header>
