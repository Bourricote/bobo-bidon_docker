<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Admins
        $user = new User();
        $user->setFirstname('Anne');
        $user->setLastname('Quiedeville');
        $user->setEmail(strtolower($user->getFirstname() . '.' . $user->getLastname() . '@orange.fr'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setStartDate(new \DateTime('2020-02-10'));
        $user->setEndDate(new \DateTime('2020-04-05'));
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Céline');
        $user->setLastname('Godichon');
        $user->setEmail(strtolower($user->getFirstname() . '.' . $user->getLastname() . '@hotmail.fr'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
