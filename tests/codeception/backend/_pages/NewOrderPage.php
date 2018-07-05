<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class NewOrderPage extends BasePage
{
    public $route = 'order/create';
    
    public function enterNewOrder() {
    	$this->actor->fillField('input[name="OrderForm[customer_id]"]', 1);
        $this->actor->fillField('input[name="OrderForm[sold_count]"]', 1);
        $this->actor->fillField('input[name="OrderForm[sold_amount]"]', 5000);
        $this->actor->fillField('input[name="OrderForm[warranty_in_month]"]', 12);
        $this->actor->click('button[type=submit]');
    }
}
