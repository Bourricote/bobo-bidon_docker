<?php namespace App\Tests;
use App\Tests\FunctionalTester;

class EditProfileCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function EditProfile(FunctionalTester $I)
    {
        // Sign in
        $I->amOnPage('/');
        $I->fillField('email','testy@test.fr');
        $I->fillField('password','coucou');
        $I->click('Connexion');

        // Go to profile
        $I->see('Mon profil');
        $I->click('Mon profil');
        $I->see('Testy Test');
        $I->see('Modifier mon profil');
        $I->click('Modifier mon profil');

        // Change name
        $I->fillField('Prénom', 'Tadaaa');
        $I->click('Mettre à jour');
        $I->see('Tadaaa Test');

        // Change back to previous name
        $I->click('Modifier mon profil');
        $I->fillField('Prénom', 'Testy');
        $I->click('Mettre à jour');
        $I->see('Testy Test');
    }
}
