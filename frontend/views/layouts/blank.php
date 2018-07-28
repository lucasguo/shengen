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
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


