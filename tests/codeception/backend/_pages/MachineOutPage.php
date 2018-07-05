<?php

namespace tests\codeception\backend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \codeception_frontend\AcceptanceTester|\codeception_frontend\FunctionalTester|\codeception_backend\AcceptanceTester|\codeception_backend\FunctionalTester $actor
 */
class MachineOutPage extends BasePage
{
    public $route = 'order/out';
    
    public function makeMachineOut($id) {
    	$this->actor->fillField('input#machine0Id', $id);
        $this->actor->click('button[type=submit]');
    }
}
