<?php


namespace App\Service;


use App\Entity\User;

class UserService
{
    public function userHasStartedDiet(User $user): bool
    {
        if (!$user->getStartDate()) {
            return false;
        }
        return true;
    }

    public function getUserDietDates(User $user): array
    {
        $startDate = $user->getStartDate();
        $startDateClone = clone $startDate;

        $endDate = $user->getEndDate();
        $endDateClone = clone $endDate;

        return [
            'startDate' => $startDateClone,
            'endDate' => $endDateClone,
        ];
    }

}