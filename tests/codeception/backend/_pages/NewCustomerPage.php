<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class NewCustomerPage extends BasePage
{
    public $route = 'customer/create';
    
    public function enterNewCustomer($corp, $name, $mobile, $address) {
    	$this->actor->fillField('input[name="Customer[customer_corp]"]', $corp);
        $this->actor->fillField('input[name="Customer[customer_name]"]', $name);
        $this->actor->fillField('input[name="Customer[customer_mobile]"]', $mobile);
        $this->actor->fillField('textarea[name="Customer[customer_address]"]', $address);
        $this->actor->click('button[type=submit]');
    }
}
