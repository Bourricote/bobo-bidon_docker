<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class FoodCrudCest
{
    private $foodId;

    public function _before(AcceptanceTester $I)
    {
        // Sign in as admin and go to Admin section for foods
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-Bidon');
        $I->click('Gestion');
        $I->see('Aliments', '//a[contains(@href,\'/food/admin\')]');
        $I->click('//a[contains(@href,\'/food/admin\')]');
        $I->seeCurrentUrlEquals('/food/admin');
    }

    // tests
    public function createFood(AcceptanceTester $I)
    {
        $I->amOnPage('/food/admin');
        $I->see('Ajouter');
        $I->click('Ajouter');
        $I->fillField('Nom','AAAAAA Test');
        $I->selectOption('//fieldset/div/div/input[@id=\'food_isHighFodmap_0\']', '0');
        $I->fillField('Oligos','0');
        $I->fillField('Fructose','0');
        $I->fillField('Polyols','0');
        $I->fillField('Lactose','0');
        $I->selectOption('Catégorie', 'Produits laitiers');
        $I->see('Enregistrer');
        $I->click('Enregistrer');
        $I->see('Liste des aliments');
        $I->seeCurrentUrlEquals('/food/admin');
        $this->foodId = $I->grabTextFrom('//table/tbody/tr[1]/td[1]');
    }

    public function readFood(AcceptanceTester $I)
    {
        $I->amOnPage('/food/admin/' . $this->foodId);
        $I->see('AAAAAA Test');
        $I->see('Retour à la liste');
    }

    public function editFood(AcceptanceTester $I)
    {
        $I->amOnPage('/food/admin/' . $this->foodId . '/edit');
        $I->see('Modifier l\'aliment');
        $I->fillField('Nom', 'AAAAAA Test bis');
        $I->click('Enregistrer');
        $I->see('AAAAAA Test bis');
    }

    public function deleteFood(AcceptanceTester $I)
    {
        $I->amOnPage('/food/admin/' . $this->foodId);
        $I->see('AAAAAA Test bis');
        $I->see('Supprimer');
        $I->click('Supprimer');
        $I->dontSee('AAAAAA Test bis');
    }
}
