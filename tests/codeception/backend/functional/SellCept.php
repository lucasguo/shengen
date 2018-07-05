<?php

use tests\codeception\backend\FunctionalTester;
use tests\codeception\backend\_pages\NewCustomerPage;
use tests\codeception\backend\_pages\LoginPage;
use tests\codeception\backend\_pages\NewOrderPage;
use tests\codeception\backend\_pages\LogoutPage;
use tests\codeception\backend\_pages\OrderConfirmPage;
use tests\codeception\backend\_pages\MachineOutPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure new customer entered');
// $I->amLoggedInAs(2); //salesman

$I->amGoingTo('login as salesman');
$loginPage = LoginPage::openBy($I);
$loginPage->login("15959287841", "123456");
$I->expectTo('login successfully');
$I->canSee('欢迎使用圣恩管理系统', 'h1');

$I->amGoingTo('submit new customer');
$newCustomerPage = NewCustomerPage::openBy($I);
$newCustomerPage->enterNewCustomer("corp1", "name1", "33333", "address1");

$I->expectTo('customer created successfully');
$I->see('name1', 'h1');

$I->amGoingTo('create new order');
$newOrderPage = NewOrderPage::openBy($I);

$I->expectTo('deny creating order by salesman');
$I->see('Forbidden (#403)', 'h3');

$I->amGoingTo('logout the salesman');
$logoutPage = LogoutPage::openBy($I);

$I->wantTo('ensure new order entered');

$I->amGoingTo('login as accountant');
$loginPage = LoginPage::openBy($I);
$loginPage->login("15959287842", "123456");

$I->amGoingTo('create new order');
$newOrderPage = NewOrderPage::openBy($I);

$I->expectTo('create new order successfully');
$newOrderPage->enterNewOrder();
$I->see('已录入', 'td');

$I->expectTo('confirm the order successfully');
$confirmOrderPage = OrderConfirmPage::openBy($I, ['id' => 1]);
$I->see('已入账', 'td');

$I->expectTo('deny outing order by accountant');
$outPage = MachineOutPage::openBy($I, ['id' => 1]);
$I->see('Forbidden (#403)', 'h3');

$I->amGoingTo('logout the accountant');
$logoutPage = LogoutPage::openBy($I);

$I->wantTo('ensure machine out');

$I->amGoingTo('login as warehousing');
$loginPage = LoginPage::openBy($I);
$loginPage->login("15959287844", "123456");

$I->amGoingTo('out the wrong machine');
$outPage = MachineOutPage::openBy($I, ['id' => 1]);
$outPage->makeMachineOut(2); // sold one
$I->see("选中了不存在或已出库的仪器");

$I->amGoingTo('out the right machine');
$outPage = MachineOutPage::openBy($I, ['id' => 1]);
$outPage->makeMachineOut(1); // normal one
$I->see('出库', 'td');
