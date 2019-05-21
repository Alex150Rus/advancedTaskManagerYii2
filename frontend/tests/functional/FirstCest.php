<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class FirstCest
{
    // tests
    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data) {
        $I->amOnPage([$data['url']]);
        $I->see($data['h1'], 'h1');
    }
//    public function tryToTest(FunctionalTester $I)
//    {
//        $I->amOnPage(['/']);
//        $I->see('Congratulations!', 'h1');
//
//        $I->amOnPage(['site/contact']);
//        $I->see('Contact', 'h1');
//    }


    public function pageProvider() {
        return [

            ['url' => "/", 'h1' => "Congratulations!"],
            ['url' => "site/about", 'h1' => "About"],
            ['url' => "site/contact", 'h1' => "Contact"],

        ];
    }
}
