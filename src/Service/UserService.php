<?php


namespace App\Service;


use App\Entity\User;

class UserService
{
    public function userHasStartedDiet (User $user): bool
    {
        if (!$user->getStartDate()) {
            return false;
        }
        return true;
    }
}