<?php
/**
 * Created by PhpStorm.
 * User: Liubin
 * Date: 2018/7/10
 * Time: 23:04
 */

namespace frontend\assets;
use yii\web\AssetBundle;

class FullPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fullpage.min.css',
    ];
    public $js = [
        'js/fullpage.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}