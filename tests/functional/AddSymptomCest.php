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
        $I->amOnPage('/');
        $I->fillField('email','testy@test.fr');
        $I->fillField('password','coucou');
        $I->click('Connexion');
        $I->see('Mon profil');
        $I->click('Mon profil');
        $I->see('Ton email');
        $this->userId = $I->grabFromCurrentUrl('~/user/profile/(\d+)$~');
        $I->amOnPage('/symptom/addsymptom/' . $this->userId);
        $I->see('Ajouter vos Symptômes');
        $date = new DateTime();
        $I->fillField('Date', date_format($date, 'Y-m-d'));
        $I->checkOption('Douleurs abdominales');
        $I->checkOption('Ballonnements');
        $I->click('Ajouter');
        $I->see('Vos changements ont été sauvegardés !');
        $I->amOnPage('/user/showsymptom');
        $I->see('Douleurs abdominales le ' . date_format($date,'d/m/Y') . ' à 00:00');
        $I->see('Ballonnements le '. date_format($date,'d/m/Y') . ' à 00:00');
    }
}
