<?php

namespace App\DataFixtures;

use App\Entity\Symptom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SymptomFixtures extends Fixture
{

    const SYMPTOMS = [
        'Douleurs abdominales',
        'Ballonnements',
        'Constipation',
        'Diarrhée',
        'Flatulences',
        'Mucus dans les selles',
        'Evacuation non complète',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SYMPTOMS as $name) {
            $symptom = new Symptom();
            $symptom->setName($name);
            $manager->persist($symptom);
        }

        $manager->flush();
    }
}
