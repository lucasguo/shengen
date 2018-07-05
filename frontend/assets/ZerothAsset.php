<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ZerothAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/zeroth';
    public $css = [
        'css/layout.css',
        'css/reset.css',
        'css/responsive.css',
        'css/responsiveslides.css',
        'css/style.css',
        'css/zerogrid.css',
    ];
    public $js = [
        'js/css3-mediaqueries.js',
        'js/cufon-yui.js',
        'js/cufon-replace.js',
        'js/html5.js',
        'js/jcarousellite.js',
        'js/jquery.easing.1.3.js',
        'js/responsiveslides.js',
        'js/script.js',
        'js/tabs.js',
        'js/tms-0.3.js',
        'js/tms_presets.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
