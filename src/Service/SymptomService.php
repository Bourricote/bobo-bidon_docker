<?php


namespace App\Service;


use App\Entity\Symptom;
use App\Entity\User;
use DateInterval;
use DateTime;

class SymptomService
{
    private $userService;
    private $genericService;

    public function __construct(UserService $userService, GenericService $genericService)
    {
        $this->userService = $userService;
        $this->genericService = $genericService;
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

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];

        $nbSymptomsPerDay = [];

        $labelsDays = [];
        for ($i = 0; $i <= $this->genericService::NB_DAYS_DIET; $i++) {
            if ( $i!= 0){
                $newDate = $startDate->add(new DateInterval('P1D'));
            } else {
                $newDate = $startDate;
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

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];

        $nbSymptomsPerWeek = [];
        $oldDate = clone $startDate;

        for ($i = 0; $i < $this->genericService::NB_WEEKS_DIET; $i++) {
            $newDate = $startDate->add(new DateInterval('P7D'));
                        $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $nbSymptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
        }

        $labelWeeks = $this->genericService->generateDietWeeksLabels($categories);

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

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];

        $nbSymptomsPerWeek = [];

        $oldDate = clone $startDate;
        for ($i = 0; $i <= $this->genericService::NB_WEEKS_DIET; $i++) {
            $newDate = $startDate->add(new DateInterval('P7D'));
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
        if (!$this->userService->userHasStartedDiet($user)) {
            return [
                'days_data' => [0, $this->genericService::NB_DAYS_DIET ],
                'message' => 'Vous n\'avez pas commencé votre régime !',
                'category' => null
            ];
        }

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];
        $endDate = $dietDates['endDate'];

        //Diet ended
        $today = new DateTime();

        if ($today >= $endDate) {
            return [
                'days_data' => [$this->genericService::NB_DAYS_DIET , 0],
                'message' => 'Vous avez fini votre régime !',
                'category' => null
            ];
        }

        //Diet in progress
        $daysDone = $startDate->diff($today)->days;
        $nbWeeksDone = (int)floor($daysDone / $this->genericService::DAYS_PER_WEEK);

        $daysLeft = ($this->genericService::NB_DAYS_DIET) - $daysDone;
        $message = 'Vous êtes à la semaine ' . ($nbWeeksDone + 1) . ' de votre régime !';

        $currentCategory = null;
        foreach ($categories as $category) {
            if ($category->getDietWeek() === ($nbWeeksDone + 1)) {
                $currentCategory = $category;
            }
        }

        return [
            'days_data' => [$daysDone, $daysLeft],
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
     * @return array[]|null
     */
    public function associateSymptomsToDietWeeks(User $user, array $categories)
    {
        if (!$this->userService->userHasStartedDiet($user)) {
            return null;
        }

        $dietDates = $this->userService->getUserDietDates($user);
        $startDate = $dietDates['startDate'];

        $userSymptoms = $user->getUserSymptoms();
        $labelWeeks = $this->genericService->generateDietWeeksLabels($categories);

        return $this->genericService->associate($labelWeeks, $userSymptoms, $startDate);
    }

}