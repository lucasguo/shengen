<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class OrgChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/jquery.jOrgChart.css',
    ];
    public $js = [
    	'js/jquery.jOrgChart.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
