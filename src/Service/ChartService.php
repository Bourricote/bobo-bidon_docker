<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Symptom;
use App\Entity\User;
use App\Repository\CategoryRepository;
use DateInterval;
use DateTime;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

class ChartService
{
    const DAYS_PER_WEEK = 7;

        /**
     * Calculate number of all symptoms per day for chart SymptomsPerDay
     * @param User $user
     * @return array[]
     */
    public function generateDataPerDay(User $user)
    {
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
        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $endDate = $user->getEndDate();

        $nbWeeks = (($startDateWeeks->diff($endDate)->days) / self::DAYS_PER_WEEK);

        $nbSymptomsPerWeek = [];

        $labelWeeks = [];
        $oldDate = clone $startDateWeeks;
        for ($i = 0; $i <= $nbWeeks; $i++) {
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));
            if ($i < 2) {
                $labelWeeks[] = $i + 1 . '. -';
            }
            foreach ($categories as $category) {
                if ($category->getDietWeek() === $i + 1) {
                    $labelWeeks[] = $i + 1 . '. ' . $category->getName();
                }
            }
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $nbSymptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
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
        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $endDate = $user->getEndDate();

        $nbWeeks = (($startDateWeeks->diff($endDate)->days) / self::DAYS_PER_WEEK);

        $nbSymptomsPerWeek = [];

        $oldDate = clone $startDateWeeks;
        for ($i = 0; $i <= $nbWeeks; $i++) {
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
     * @param User $user
     * @param array $categories
     * @return float[]|int[]
     */
    public function generateDataForDietWeeks(User $user, array $categories)
    {
        if (!$user->getStartDate()) {
            return ['done' => 0, 'left' => 1000, 'message' => 'Vous n\'avez pas commencé votre régime !'];
        }

        $endDate = $user->getEndDate();
        $today = new DateTime();

        if ($today >= $endDate) {
            return ['done' => 100, 'left' => 0, 'message' => 'Vous avez fini votre régime !'];
        }

        $nbOfWeeksDiet = 8;

        $startDate = $user->getStartDate();

        $nbWeeksDone = (int)floor((($startDate->diff($today)->days) / self::DAYS_PER_WEEK));

        $done = ($nbWeeksDone * 100) / $nbOfWeeksDiet;
        $left = 100 - $done;
        $message = 'Vous êtes à la semaine ' . ($nbWeeksDone + 1) . ' de votre régime !';

        $currentCategory = null;
        foreach ($categories as $category) {
            if ($category->getDietWeek() === ($nbWeeksDone + 1)) {
                $currentCategory = $category;
            }
        }

        return [
            'done' => $done,
            'left' => $left,
            'message' => $message,
            'category' => $currentCategory,
            ];
    }
}