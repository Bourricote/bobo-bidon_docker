<?php

namespace App\Tests;

use App\Tests\AcceptanceTester;

class SignupCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function signUpSuccessfully(AcceptanceTester $I)
    {
        // Register new user and logout
        $I->amOnPage('/register');
        $I->fillField('Email','anna.banana@orange.fr');
        $I->fillField('Mot de passe','password');
        $I->fillField('Confirmer le mot de passe','password');
        $I->fillField('Prénom','Anna');
        $I->fillField('Nom','Banana');
        $I->click('Inscription');
        $I->see('Bobo-Bidon');
        $I->see('Mon profil');
        $I->click('Mon profil');
        $I->see('Ton email');
        $userId = $I->grabFromCurrentUrl('~/user/profile/(\d+)$~');
        $I->see('Se déconnecter');
        $I->click('Se déconnecter');

        // Sign in as admin
        $I->amOnPage('/');
        $I->fillField('email','anne.quiedeville@orange.fr');
        $I->fillField('password','password');
        $I->click('Connexion');
        $I->see('Bobo-Bidon');

        // Delete new user
        $I->amOnPage('/user/admin');
        $I->see('anna.banana@orange.fr');
        $I->amOnPage('/user/admin/' . $userId . '/edit');
        $I->see('Delete');
        $I->click('Delete');
        $I->amOnPage('/user/admin');
        $I->dontSee('anna.banana@orange.fr');
    }
}
