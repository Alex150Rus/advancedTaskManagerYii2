<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class LiActiveCest
{
    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data) {
        $I->amOnPage([$data['url']]);
        $I->see($data['li'], '.active');
    }


    public function pageProvider() {
        return [

            ['url' => "/", 'li'=>"Home"],
            ['url' => "site/about", 'li'=>"About"],
            ['url' => "site/contact", 'li'=>"Contact"],
            ['url' => "site/login", 'li'=>"Login"],
            ['url' => "site/signup", 'li'=>"Signup"]

        ];
    }
}
