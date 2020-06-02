<?php

namespace App\Tests;

use App\Tests\AcceptanceTester;

class SignupCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // test commenté car crée un user et je sais pas encore comment le supprimer :/
    /*public function signUpSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/register');
        $I->fillField('Email','anna.banana@orange.fr');
        $I->fillField('Mot de passe','password');
        $I->fillField('Confirmer le mot de passe','password');
        $I->fillField('Prénom','Anna');
        $I->fillField('Nom','Banana');
        $I->click('Inscription');
        $I->see('Bobo-Bidon');
        //$I->seeInDatabase('user', ['email' => 'anna.banana@orange.fr']);
        $I->amOnPage('/user/admin');
        $I->see('anna.banana@orange.fr');
    }*/
}
