<?php


namespace App\Service;


use App\Entity\Symptom;
use App\Entity\User;
use App\Repository\CategoryRepository;
use DateInterval;
use phpDocumentor\Reflection\Types\Integer;

class ChartService
{
    const DAYS_PER_WEEK = 7;

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

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
     * @return array[]
     */
    public function generateDataPerWeek(User $user)
    {
        $categories = $this->categoryRepository->findAll();

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
}