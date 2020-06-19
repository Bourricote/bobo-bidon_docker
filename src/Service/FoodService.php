<?php


namespace App\Service;


use App\Entity\User;

class FoodService
{
    private $userService;
    private $genericService;

    public function __construct(UserService $userService, GenericService $genericService)
    {
        $this->userService = $userService;
        $this->genericService = $genericService;
    }

    /**
     * Returns array of diet weeks with associated foods
     * @param User $user
     * @param array $categories
     * @return array[]|null
     */
    public function associateFoodsToDietWeeks(User $user, array $categories)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];

        $userFoods = $user->getUserFoods();
        $labelWeeks = $this->genericService->generateDietWeeksLabels($categories);

        return $this->genericService->associate($labelWeeks, $userFoods, $startDate);
    }

}