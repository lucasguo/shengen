<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '厦门市圣恩医疗科技有限公司';

\frontend\assets\FullPageAsset::register($this);
\frontend\assets\HomeAsset::register($this);
?>

<div id="fullpage">
    <div class="section" id="section1">Some section 1</div>
    <div class="section" id="section2">Some section 2</div>
    <div class="section" id="section3">Some section 3</div>
    <div class="section" id="section4">Some section 4</div>
    <div class="section" id="section5">Some section 5</div>
</div>

<?php
$script = <<<JS
    $('#fullpage').fullpage();
JS;
$this->registerJs($script);
?>
