<?php


namespace App\Service;


use App\Entity\User;
use DateTime;

class TimelineService
{
    /**
     * Calculate number of all symptoms per day for chart SymptomsPerDay
     * @param User $user
     * @param array $weeks
     * @return array[]
     */
    public function generateTimeline(User $user, array $weeks)
    {
        //Diet not started yet
        if (!$user->getStartDate()) {
            $nbWeeksDone =  -1;
        } else {
            //Diet ended
            $endDate = $user->getEndDate();
            $today = new DateTime();

            if ($today >= $endDate) {
                $nbWeeksDone = ChartService::NB_WEEKS_DIET;
            } else {
                //Diet in progress
                $startDate = $user->getStartDate();
                $today = new DateTime();

                $daysDone = $startDate->diff($today)->days;
                $nbWeeksDone = (int)floor($daysDone / ChartService::DAYS_PER_WEEK);
            }
        }

        for ($i = 1; $i <= count($weeks); $i++) {
            if ($weeks[$i]['week_nb'] <= $nbWeeksDone) {
                $weeks[$i]['status'] = 'completed';
            } elseif ($weeks[$i]['week_nb'] === $nbWeeksDone + 1) {
                $weeks[$i]['status'] = 'in-progress';
            } else {
                $weeks[$i]['status'] = 'future';
            }
        }

        return $weeks;
    }
}