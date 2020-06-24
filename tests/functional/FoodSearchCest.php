<?php namespace App\Tests;
use App\Tests\FunctionalTester;

class FoodSearchCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->fillField('email','testy@test.fr');
        $I->fillField('password','coucou');
        $I->click('Connexion');
        $I->see('Bobo-bidon');
        $I->amOnPage('/food/');
    }

    // tests
    public function FoodSearchByName(FunctionalTester $I)
    {
        $I->see('Bacon');
        $I->see('Abricot');
        $I->see('Chercher');
        $I->fillField('food_search[searchText]', 'abricot');
        $I->click('Chercher');
        $I->dontSee('Bacon');
        $I->see('Abricot');
    }

    public function FoodSearchByCategory(FunctionalTester $I)
    {
        $I->seeElement('//td[text()=\'Boissons\']');
        $I->seeElement('//td[text()=\'Fruits\']');
        $I->see('Chercher');
        $I->selectOption('//select[@id=\'food_search_category\']', 'Fruits');
        $I->click('Chercher');
        $I->dontSeeElement('//td[text()=\'Boissons\']');
        $I->seeElement('//td[text()=\'Fruits\']');
    }

    public function FoodSearchByFodmapLevel(FunctionalTester $I)
    {
        $I->seeElement('i', ['class' => 'fas fa-check-circle textPinkMediumLight']);
        $I->seeElement('i', ['class' => 'fas fa-times-circle textPurpleDark']);
        $I->see('Chercher');
        $I->selectOption('//fieldset/div/div/input[@id=\'food_search_isHighFodmap_1\']', '1');
        $I->click('Chercher');
        $I->dontSeeElement('i', ['class' => 'fas fa-times-circle textPurpleDark']);
        $I->seeElement('i', ['class' => 'fas fa-check-circle textPinkMediumLight']);
    }

}
