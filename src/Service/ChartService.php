<?php


namespace App\Service;


use App\Entity\Symptom;
use App\Entity\User;
use DateInterval;
use DateTime;

class ChartService
{
    const DAYS_PER_WEEK = 7;
    const NB_WEEKS_DIET = 8;
    const NB_DAYS_DIET = self::NB_WEEKS_DIET * 7;

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Gives array of all diet weeks with category label when necessary
     * @param array $categories
     * @return float[]|int[]
     */
    public function generateDietWeeksLabels(array $categories)
    {
        $labelWeeks = [];

        for ($i = 0; $i < self::NB_WEEKS_DIET; $i++) {
            if ($i < 2) {
                $labelWeeks[] = $i + 1 . '. -';
            }
            foreach ($categories as $category) {
                if ($category->getDietWeek() === $i + 1) {
                    $labelWeeks[] = $i + 1 . '. ' . $category->getName();
                }
            }
        }

        return $labelWeeks;
    }

    /**
     * Calculate number of all symptoms per day for chart SymptomsPerDay
     * @param User $user
     * @return array[]
     */
    public function generateDataPerDay(User $user)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateDays = clone $startDate;

        $endDate = $user->getEndDate();

        $nbDays = $startDateDays->diff($endDate)->days;

        $nbSymptomsPerDay = [];

        $labelsDays = [];
        for ($i = 0; $i <= $nbDays; $i++) {
            if ( $i!= 0){
                $newDate = $startDateDays->add(new DateInterval('P1D'));
            } else {
                $newDate = $startDateDays;
            }
            $labelsDays[] = date_format($newDate, 'd/m/Y');
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if (date_format($userSymptom->getDate(), 'd/m/Y') == date_format($newDate, 'd/m/Y')) {
                    $j ++ ;
                }
            }
            $nbSymptomsPerDay[] = $j;
        }

        return ['labelDays' => $labelsDays, 'nbSymptomsPerDay' => $nbSymptomsPerDay];
    }

    /**
     * Calculate number of all symptoms per week for chart SymptomsPerWeek
     * @param User $user
     * @param array $categories
     * @return array[]
     */
    public function generateDataPerWeek(User $user, array $categories)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $nbSymptomsPerWeek = [];
        $oldDate = clone $startDateWeeks;

        for ($i = 0; $i < self::NB_WEEKS_DIET; $i++) {
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));
                        $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $nbSymptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
        }

        $labelWeeks = $this->generateDietWeeksLabels($categories);

        if (count($labelWeeks) !== count($nbSymptomsPerWeek)) {
            return null;
        }

        return ['labelWeeks' => $labelWeeks, 'nbSymptomsPerWeek' => $nbSymptomsPerWeek];
    }

    /**
     * Calculate number of given symptom per week for chart perSymptom
     * @param User $user
     * @param Symptom $symptom
     * @return array[]
     */
    public function generateDataPerWeekPerSymptom(User $user, Symptom $symptom)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $nbSymptomsPerWeek = [];

        $oldDate = clone $startDateWeeks;
        for ($i = 0; $i <= self::NB_WEEKS_DIET; $i++) {
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getSymptom() === $symptom && $userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $nbSymptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
        }

        return ['nbSymptomsPerWeek' => $nbSymptomsPerWeek];
    }

    /**
     * Calculate number of days of diet done for chart of dashboard1
     * @param User $user
     * @param array $categories
     * @return float[]|int[]
     */
    public function generateDataForDietWeeks(User $user, array $categories)
    {
        //Diet not started yet
        if (!$user->getStartDate()) {
            return [
                'weeks_data' => [0, self::NB_DAYS_DIET],
                'message' => 'Vous n\'avez pas commencé votre régime !',
                'category' => null
            ];
        }

        //Diet ended
        $endDate = $user->getEndDate();
        $today = new DateTime();

        if ($today >= $endDate) {
            return [
                'weeks_data' => [self::NB_DAYS_DIET, 0],
                'message' => 'Vous avez fini votre régime !',
                'category' => null
            ];
        }

        //Diet in progress
        $startDate = $user->getStartDate();

        $daysDone = $startDate->diff($today)->days;
        $nbWeeksDone = (int)floor($daysDone / self::DAYS_PER_WEEK);

        $daysLeft = (self::NB_DAYS_DIET) - $daysDone;
        $message = 'Vous êtes à la semaine ' . ($nbWeeksDone + 1) . ' de votre régime !';

        $currentCategory = null;
        foreach ($categories as $category) {
            if ($category->getDietWeek() === ($nbWeeksDone + 1)) {
                $currentCategory = $category;
            }
        }

        return [
            'weeks_data' => [$daysDone, $daysLeft],
            'message' => $message,
            'category' => $currentCategory,
            ];
    }

    /**
     * Calculate number of symptoms per category for chart of dashboard2
     * @param User $user
     * @param array $categories
     * @return float[]|int[]
     */
    public function generateDataForCategories(User $user, array $categories)
    {
        $data = $this->generateDataPerWeek($user, $categories);

        if ($data === null) {
            return null;
        }

        $categoriesLabels = array_slice($data['labelWeeks'], 2);
        $symptoms = array_slice($data['nbSymptomsPerWeek'], 2);

        $max = 0;
        $worstCategory = '';
        for ($i = 0; $i < count($categoriesLabels); $i++) {
            $categoriesLabels[$i] = substr($categoriesLabels[$i], 3);
            if ($symptoms[$i] > $max) {
                foreach ($categories as $category) {
                    if ($category->getName() === $categoriesLabels[$i]) {
                        $worstCategory = $category;
                    }
                }
                $max = $symptoms[$i];
            }
        }
        return [
            'categories_labels' =>$categoriesLabels,
            'nbSymptomsPerWeek' => $symptoms,
            'worst_category' => $worstCategory
        ];
    }

    /**
     * Returns array of diet weeks with associated symptoms
     * @param User $user
     * @param array $categories
     * @return float[]|int[]
     */
    public function associateSymptomsToDietWeeks(User $user, array $categories)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $userSymptoms = $user->getUserSymptoms();

        $oldDate = clone $startDate;

        $labelWeeks = $this->generateDietWeeksLabels($categories);
        $weeksWithSymptoms = [];

        foreach ($labelWeeks as $week) {
            $weeksWithSymptoms[$week] = [];
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $weeksWithSymptoms[$week][] = $userSymptom;
                }
            }
            $oldDate = clone $newDate;
        }

        return $weeksWithSymptoms;
    }

    /**
     * Returns array of diet weeks with associated foods
     * @param User $user
     * @param array $categories
     * @return float[]|int[]
     */
    public function associateFoodsToDietWeeks(User $user, array $categories)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $userFoods = $user->getUserFoods();

        $oldDate = clone $startDate;

        $labelWeeks = $this->generateDietWeeksLabels($categories);
        $weeksWithFoods = [];

        foreach ($labelWeeks as $week) {
            $weeksWithFoods[$week] = [];
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));
            foreach ($userFoods as $userFood) {
                if ($userFood->getDate() >= $oldDate && $userFood->getDate() < $newDate) {
                    $weeksWithFoods[$week][] = $userFood;
                }
            }
            $oldDate = clone $newDate;
        }

        return $weeksWithFoods;
    }
}