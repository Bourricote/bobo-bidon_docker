<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class CategoryCrudCest
{
    private $categoryId;

    public function _before(AcceptanceTester $I)
    {
        // Sign in as admin and go to Admin section for categories
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-Bidon');
        $I->click('Gestion');
        $I->see('Catégories d\'aliments');
        $I->click('Catégories d\'aliments');
        $I->seeCurrentUrlEquals('/category/admin');
    }

    // tests
    public function createCategory(AcceptanceTester $I)
    {
        $I->amOnPage('/category/admin');
        $I->see('Ajouter');
        $I->click('Ajouter');
        $I->fillField('Nom','Catégorie Test');
        $I->fillField('Semaine de régime',1);
        $I->click('Enregistrer');
        $I->amOnPage('/category/admin');
        $I->see('Catégorie Test');
        $this->categoryId = $I->grabTextFrom('//table/tbody/tr[last()]/td[1]');
    }

    public function readCategory(AcceptanceTester $I)
    {
        $I->amOnPage('/category/admin/' . $this->categoryId);
        $I->see('Catégorie Test');
        $I->see('Retour à la liste');
    }

    public function editCategory(AcceptanceTester $I)
    {
        $I->amOnPage('/category/admin/' . $this->categoryId . '/edit');
        $I->see('Retour à la liste');
        $I->fillField('Nom', 'Catégorie Test bis');
        $I->click('Enregistrer');
        $I->see('Catégorie Test bis');
    }

    public function deleteCategory(AcceptanceTester $I)
    {
        $I->amOnPage('/category/admin/' . $this->categoryId);
        $I->see('Catégorie Test bis');
        $I->see('Supprimer');
        $I->click('Supprimer');
        $I->dontSee('Catégorie Test bis');
    }
}
