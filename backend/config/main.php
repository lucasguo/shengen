<?php
$qiniu = array_merge(
    require(__DIR__ . '/../../common/config/params-qiniu.php')
);

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'name' => '厦门圣恩',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
    	'wechat' => [
    		'class' => 'callmez\wechat\sdk\Wechat',
    		'appId' => 'wxc64f2d010c5c30b9',
    		'appSecret' => '6a60e49592ae91d91804c41b5ca096a7',
    		'token' => '',
    	],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    	'sms' => [
    		'class' => 'backend\components\Sms',
    		'apikey' => '4b29808646c5fcbc13b6dac406ef3a48',
    		'adminUrl' => '121.40.213.250:8081',
    		'templateId' => '1443069',
    	],
    	'export' => [
    		'class' => 'backend\components\ExcelExport',
    	],
    	'alert' => [
    		'class' => 'backend\components\AlertHelper',
    	],
    	'user' => [
    		'identityClass' => 'common\models\User',
    		'authTimeout' => 600,
    	],
        'assetManager' => [
            'baseUrl' => '@web/assets',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	'modules' => [
		'gridview' =>  [
        	'class' => '\kartik\grid\Module'
    	],
		'finance' => [
			'class' => 'backend\modules\finance\Module',
		],
	],
    'params' => $params,
];
