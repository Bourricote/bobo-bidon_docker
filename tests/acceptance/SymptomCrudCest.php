<?php namespace App\Tests;
use App\Tests\AcceptanceTester;

class SymptomCrudCest
{
    private $symptomId;

    public function _before(AcceptanceTester $I)
    {
        // Sign in as admin and go to Admin section for symptoms
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-Bidon');
        $I->click('Gestion');
        $I->see('Symptômes', '//a[contains(@href,\'/symptom/admin\')]');
        $I->click('//a[contains(@href,\'/symptom/admin\')]');
        $I->seeCurrentUrlEquals('/symptom/admin');
    }

    // tests
    public function createSymptom(AcceptanceTester $I)
    {
        $I->amOnPage('/symptom/admin');
        $I->see('Ajouter');
        $I->click('Ajouter');
        $I->fillField('Nom','Symptôme Test');
        $I->click('Enregistrer');
        $I->amOnPage('/symptom/admin');
        $I->see('Symptôme Test');
        $this->symptomId = $I->grabTextFrom('//table/tbody/tr[last()]/td[1]');
    }

    public function readSymptom(AcceptanceTester $I)
    {
        $I->amOnPage('/symptom/admin/' . $this->symptomId);
        $I->see('Symptôme Test');
        $I->see('Retour à la liste');
    }

    public function editSymptom(AcceptanceTester $I)
    {
        $I->amOnPage('/symptom/admin/' . $this->symptomId . '/edit');
        $I->see('Modifier le symptôme');
        $I->fillField('Nom', 'Symptôme Test bis');
        $I->click('Enregistrer');
        $I->see('Symptôme Test bis');
    }

    public function deleteSymptom(AcceptanceTester $I)
    {
        $I->amOnPage('/symptom/admin/' . $this->symptomId);
        $I->see('Symptôme Test bis');
        $I->see('Supprimer');
        $I->click('Supprimer');
        $I->dontSee('Symptôme Test bis');
    }
}
