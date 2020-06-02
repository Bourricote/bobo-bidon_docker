<?php namespace App\Tests;
use App\Tests\FunctionalTester;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryLogin(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-bidon');
        $I->see('Se déconnecter');
        $I->click('Se déconnecter');
        $I->see('Connexion');

        // $I->seeEmailIsSent(); // only for Symfony
    }
}
