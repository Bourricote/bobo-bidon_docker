<?php namespace App\Tests;
use App\Tests\AcceptanceTester;
use DateTime;

class UserCrudCest
{
    private $userId;

    public function _before(AcceptanceTester $I)
    {
        // Sign in as admin and go to Admin section for users
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-Bidon');
        $I->click('Gestion');
        $I->see('Utilisateurs', '//a[contains(@href,\'/user/admin\')]');
        $I->click('//a[contains(@href,\'/user/admin\')]');
        $I->seeCurrentUrlEquals('/user/admin');
    }

    // tests
    public function createUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/admin');
        $I->see('Ajouter');
        $I->click('Ajouter');
        $I->fillField('Email','bidulette.delatest@test.fr');
        $I->fillField('Mot de passe','password');
        $I->fillField('Confirmer le mot de passe','password');
        $I->fillField('Prénom','Bidulette');
        $I->fillField('Nom','De La TEST');
        $I->see('Enregistrer');
        $I->click('Enregistrer');
        $I->see('Liste des utilisateurs');
        $I->seeCurrentUrlEquals('/user/admin');
        $this->userId = $I->grabTextFrom('//table/tbody/tr[last()]/td[1]');
    }

    public function readUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/admin/' . $this->userId);
        $I->see('Bidulette');
        $I->see('De La TEST');
        $I->see('Retour à la liste');
    }

    public function editUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/admin/' . $this->userId . '/edit');
        $I->see('Modifier l\'utilisateur');
        $I->fillField('Nom', 'De La TESTYYY');
        $I->click('Mettre à jour');
        $I->see('De La TESTYYY');
    }

    public function deleteUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/admin/' . $this->userId);
        $I->see('Bidulette');
        $I->see('De La TESTYYY');
        $I->see('Supprimer');
        $I->click('Supprimer');
        $I->dontSee('De La TESTYYY');
    }
}
