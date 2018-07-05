<?php
$qiniu = array_merge(
		require(__DIR__ . '/../../common/config/params-qiniu.php')
		);

return [
	'language'=>'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    	'authManager' => [
    		'class' => 'yii\rbac\DbManager'
    	],
    	'formatter' => [
    		'class' => 'common\components\SeFormatter',
    		'numberFormatterTextOptions' => [
    			NumberFormatter::NEGATIVE_PREFIX => '<span class="negative-currency">-￥',
    			NumberFormatter::NEGATIVE_SUFFIX => '</span>',
    		],
// 			'currencyCode' => 'CNY',
    	],
    	'log' => [
    		'targets' => [
    			[
    				'class' => 'yii\log\EmailTarget',
    				'mailer' => 'mailer',
    				'levels' => ['error'],
    				'categories' => ['yii\db\*'],
    				'message' => [
    					'from' => ['support@xmshengen.com'],
    					'to' => ['guoliubin85@foxmail.com'],
    					'subject' => 'Website error',
    				],
    			],
    		],
    	],
    	'qiniu' =>  [
			'class' => 'chocoboxxf\Qiniu\Qiniu',
			'accessKey' => $qiniu['accessKey'],
			'secretKey' => $qiniu['secretKey'],
			'domain' => $qiniu['domain'],
			'bucket' => $qiniu['bucket'],
			'secure' => false,
		],
    ],
];
