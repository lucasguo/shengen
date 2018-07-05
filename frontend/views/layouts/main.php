<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$asset = \frontend\assets\ZerothAsset::register($this);
$assetPath = $asset->baseUrl;

if (Yii::$app->controller->action->id === 'index') {
    $pageId = 'page1';
} else {
    $pageId = 'page2';
}

$script = <<<JS
            $("#slider").responsiveSlides({
			auto: true,
			pager: false,
			nav: true,
			speed: 500,
			maxwidth: 960,
			namespace: "centered-btns"
		  });
Cufon.now();
JS;
$this->registerJs($script);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="厦门圣恩,厦门市圣恩医疗科技,大力神">
    <meta name="description" content="厦门市圣恩医疗科技有限公司 是一家专业从事>健康产业的公司，专注于大力神肝康保BILT治疗仪、雀啄灸治疗仪在福建市场的产品推广产品销售、技术咨询、设备维护、信息服务等。">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="<?=$pageId?>">
<?php $this->beginBody() ?>

<div class="body1">
    <div class="body2">
        <div class="main zerogrid">
            <!-- header -->
            <header>
                <div class="wrapper row">
                    <h1><a href="#" id="logo"><img style="padding-top:20px;" src="css/images/logo-white.png" /></a></h1>
                    <nav>
                    <?php
                    $menuItems = [
                        ['label' => '首页', 'url' => ['/site/index'], 'options' => ['id' => 'nav1']],
//                        ['label' => '新闻中心', 'url' => ['/site/news'], 'options' => ['id' => 'nav2']],
                        ['label' => '公司简介', 'url' => ['/site/about'],'options' => ['id' => 'nav3']],
                        ['label' => '联系我们', 'url' => ['/site/contact'], 'options' => ['id' => 'nav4']],
                    ];
                    echo Nav::widget([
                        'id' => 'menu',
                        'options' => ['id' => 'menu'],
                        'items' => $menuItems,
                    ]);
                    ?>
                    </nav>
<!--                    <nav>-->
<!--                        <ul id="menu">-->
<!--                            <li id="nav1" class="active"><a href="#">首页</a></li>-->
<!--                            <li id="nav2"><a href="#">新闻中心</a></li>-->
<!--                            <li id="nav3"><a href="#">产品简介</a></li>-->
<!--                            <li id="nav4"><a href="#">产品购买</a></li>-->
<!--                            <li id="nav5"><a href="#">联系我们</a></li>-->
<!--                        </ul>-->
<!--                    </nav>-->
                </div>

                <?php if (Yii::$app->controller->action->id === 'index') { ?>
                <div class="wrapper row">
                    <div class="slider">
                        <div class="rslides_container">
                            <ul class="rslides" id="slider">
                                <li><img src="<?=$assetPath?>/images/img1.png" alt=""></li>
                                <li><img src="<?=$assetPath?>/images/img2.png" alt=""></li>
                                <li><img src="<?=$assetPath?>/images/img3.png" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </header>
            <!-- header end-->
        </div>
    </div>
</div>

        <?= Alert::widget() ?>
        <?= $content ?>
<div class="main zerogrid">
    <!-- footer -->
    <footer>
        &copy;圣恩医疗科技有限公司 <?= date('Y'); ?>
    </footer>
    <!-- footer end -->
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


