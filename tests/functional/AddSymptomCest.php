<?php namespace App\Tests;
use App\Tests\FunctionalTester;
use DateTime;

class AddSymptomCest
{
    private $userId;

    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function AddSymptoms(FunctionalTester $I)
    {
        // Sign in and grab user Id
        $I->amOnPage('/');
        $I->fillField('email','testy@test.fr');
        $I->fillField('password','coucou');
        $I->click('Connexion');
        $I->see('Bobo-bidon');
        $this->userId = $I->grabFromCurrentUrl('~/home/(\d+)$~');

        // Go to form to add symptoms
        $I->amOnPage('/symptom/addsymptom/' . $this->userId);
        $I->see('Ajouter vos Symptômes');
        $date = new DateTime();
        $I->fillField('Date', date_format($date, 'Y-m-d'));
        $I->checkOption('Douleurs abdominales');
        $I->checkOption('Ballonnements');
        $I->click('Ajouter');
        $I->see('Symptômes sauvegardés !');
        $I->amOnPage('/symptom/showsymptom/' . $this->userId);
        $I->see('Douleurs abdominales le ' . date_format($date,'d/m/Y') . ' à 00:00');
        $I->see('Ballonnements le '. date_format($date,'d/m/Y') . ' à 00:00');
    }
}
