<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CKConfigAsset extends AssetBundle
{
	const CONFIG_NAME = 'ckConfig';
	
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/ckconfig.js',
    ];
}
