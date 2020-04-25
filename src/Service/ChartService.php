<?php


namespace App\Service;


use App\Entity\User;
use DateInterval;

class ChartService
{
    public function generateDataPerDay(User $user)
    {
        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateDays = clone $startDate;

        $endDate = $user->getEndDate();

        $nbDays = $startDateDays->diff($endDate)->days;

        $symptomsPerDay = [];

        $dataDays = [];
        for ($i = 0; $i <= $nbDays; $i++) {
            if ( $i!= 0){
                $newDate = $startDateDays->add(new DateInterval('P1D'));
            } else {
                $newDate = $startDateDays;
            }
            $dataDays[] = date_format($newDate, 'd/m/Y');
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if (date_format($userSymptom->getDate(), 'd/m/Y') == date_format($newDate, 'd/m/Y')) {
                    $j ++ ;
                }
            }
            $symptomsPerDay[] = $j;
        }

        $result = ['dataDays' => $dataDays, 'symptomsPerDay' => $symptomsPerDay];

        return $result;
    }

    public function generateDataPerWeek(User $user)
    {
        $userSymptoms = $user->getUserSymptoms();

        $startDate = $user->getStartDate();
        $startDateWeeks = clone $startDate;

        $endDate = $user->getEndDate();

        $nbWeeks = (($startDateWeeks->diff($endDate)->days) / 7);

        $symptomsPerWeek = [];

        $dataWeeks = [];
        $oldDate = clone $startDateWeeks;
        for ($i = 0; $i <= $nbWeeks; $i++) {
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));

            $dataWeeks[] = date_format($newDate, 'd/m/Y');
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $symptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
        }

        $result = ['dataWeeks' => $dataWeeks, 'symptomsPerWeek' => $symptomsPerWeek];

        return $result;
    }
}
