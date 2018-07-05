<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
			<div class="site-logo">
                <img src="images/logo.png"/>
			</div>
			<div class="site-logo-mini">
                <img src="images/logo-mini.png"/>
			</div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '功能菜单', 'options' => ['class' => 'header']],
//                 	[
// 	                	'label' => '我的',
// 	                	'icon' => 'fa fa-star',
// 	                	'url' => '#',
// 	                	'visible' => Yii::$app->user->can('addCustomer'),
// 	                	'items' => [
		                	['label' => '我的客户', 'icon' => 'fa fa-star', 'url' => ['/customer/index'], 'visible' => Yii::$app->user->can('addCustomer')],
// 		                	['label' => '我的团队', 'url' => ['/customer/my-team'], 'visible' => Yii::$app->user->can('addCustomer')],
// 		                	['label' => '我的收益', 'url' => ['/customer/my-money'], 'visible' => Yii::$app->user->can('addCustomer')],
// 	                	],
//                 	],
                	[
                		'label' => '客户管理', 
                		'icon' => 'fa fa-search-plus', 
                		'url' => '#',
                		'visible' => (Yii::$app->user->can('updateCustomer') || Yii::$app->user->can('maintainDealerShop') || Yii::$app->user->can('viewAllCardBuyer')),
                		'items' => [
                			['label' => '客户管理', 'url' => ['/customer/all-index'], 'visible' => Yii::$app->user->can('updateCustomer')],
                            ['label' => '办卡客户管理', 'url' => ['/card-buyer/all-index'], 'visible' => Yii::$app->user->can('viewAllCardBuyer')],
                   			['label' => '经销商门店管理', 'url' => ['/dealer-shop/index'], 'visible' => Yii::$app->user->can('maintainDealerShop')],
                		],
                	],
                    [
                        'label' => '门店管理',
                        'icon' => 'fa fa-home',
                        'url' => '#',
                        'visible' => (Yii::$app->user->can('addCardBuyer') || Yii::$app->user->can('viewOwnCardBuyer') || Yii::$app->user->can('addEmployee')),
                        'items' => [
                            ['label' => '添加顾客', 'url' => ['/card-buyer/create'], 'visible' => Yii::$app->user->can('addCardBuyer')],
                            ['label' => '顾客列表', 'url' => ['/card-buyer/index'], 'visible' => Yii::$app->user->can('viewOwnCardBuyer') || Yii::$app->user->can('addCardUsage')],
                            ['label' => '员工管理', 'url' => ['/employee/index'], 'visible' => Yii::$app->user->can('addEmployee')],
                            ['label' => '门店统计', 'url' => ['/card-buyer/info'], 'visible' => Yii::$app->user->can('viewOwnCardBuyer')],
                        ],
                    ],
                	[
	                	'label' => '仪器管理',
	                	'icon' => 'fa fa-cubes',
	                	'url' => '#',
	                	'visible' => Yii::$app->user->can('manageMachine'),
	                	'items' => [
	                		['label' => '仪器管理', 'url' => ['/machine/index'], 'visible' => Yii::$app->user->can('manageMachine')],
	                		['label' => '订单出库', 'url' => ['/order/out-index'], 'visible' => Yii::$app->user->can('manageMachine')],
	                		['label' => '配件管理', 'url' => ['/part/index'], 'visible' => Yii::$app->user->can('manageMachine')],
	                	],
                	],
                	['label' => '订单管理', 'icon' => 'fa fa-file-text', 'url' => ['/order/index'], 'visible' => (Yii::$app->user->can('addOrder') || Yii::$app->user->can('updateOrder'))],
                    ['label' => '文章管理', 'icon' => 'fa fa-book', 'url' => ['/article/index'], 'visible' => (Yii::$app->user->can('maintainArticle'))],
                    ['label' => '用户管理', 'icon' => 'fa fa-users', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('manageUser')],
                	[
	                	'label' => '财务管理',
	                	'icon' => 'fa fa-money',
	                	'url' => '#',
	                	'visible' => (Yii::$app->user->can('addFinance') || Yii::$app->user->can('updateFinance') || Yii::$app->user->can('viewFinance')),
	                	'items' => [
                            ['label' => '收支情况(新)', 'url' => ['/finance/default/index', 'isNew' => true], 'visible' => (Yii::$app->user->can('addFinance') || Yii::$app->user->can('updateFinance'))],
                            ['label' => '财务报表(新)', 'url' => ['/finance/default/chart', "isNew" => true], 'visible' => Yii::$app->user->can('viewFinance')],
	                		['label' => '收支情况', 'url' => ['/finance/default/index'], 'visible' => (Yii::$app->user->can('addFinance') || Yii::$app->user->can('updateFinance'))],
	                		['label' => '财务报表', 'url' => ['/finance/default/chart'], 'visible' => Yii::$app->user->can('viewFinance')],
	                	],
                	],
                	['label' => '内部文件', 'icon' => 'fa fa-file-word-o', 'url' => ['/meeting-record/index'], 'visible' => Yii::$app->user->can('meetingRecord')],
                	[
	                	'label' => '系统设置',
	                	'icon' => 'fa fa-gears',
	                	'url' => '#',
	                	'visible' => Yii::$app->user->can('manageProduct'),
	                	'items' => [
	                		['label' => '产品管理', 'url' => ['/product/index'], 'visible' => Yii::$app->user->can('manageProduct')],
// 	                		['label' => '提成设置', 'url' => ['/bonus/update'], 'visible' => Yii::$app->user->can('manageProduct')],
	                		['label' => '配件类型管理', 'url' => ['/part-type/index'], 'visible' => Yii::$app->user->can('manageProduct')],
	                		['label' => '理疗卡类型管理', 'url' => ['/card-type/index'], 'visible' => Yii::$app->user->can('maintainCardType')],
//                            ['label' => '症状管理', 'url' => ['/symptom/index'], 'visible' => Yii::$app->user->can('maintainCardType')],
	                	],
                	],
//                 	['label' => '模拟测试', 'icon' => 'fa fa-balance-scale', 'url' => ['/test/index'], 'visible' => Yii::$app->user->can('administrator')],
                ],
            ]
        ) ?>

    </section>

</aside>