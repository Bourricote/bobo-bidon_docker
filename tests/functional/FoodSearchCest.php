<?php namespace App\Tests;
use App\Tests\FunctionalTester;

class FoodSearchCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function FoodSearch(FunctionalTester $I)
    {
        // Sign in
        $I->amOnPage('/');
        $I->fillField('email','testy@test.fr');
        $I->fillField('password','coucou');
        $I->click('Connexion');

        // Go to food section and search by name
        $I->see('Aliments');
        $I->click('Aliments');
        $I->see('Bacon');
        $I->see('Apples');
        $I->see('Chercher');
        $I->fillField('food_search[searchText]', 'apples');
        $I->click('Chercher');
        $I->dontSee('Bacon');
        $I->see('Apples');
    }
}
