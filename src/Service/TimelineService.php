<?php


namespace App\Service;


use App\Entity\User;
use DateTime;

class TimelineService
{
    /**
     * Generate weeks array for timeline
     * @param array $categories
     * @return array[]
     */
    protected function generateWeeks(array $categories)
    {
        $weeks = [];
        for ($i = 1; $i <= 2; $i++) {
            $weeks[$i] = [
                'week_nb' => $i,
                'message' => 'Régime strict sans FODMAPs',
                'category_id' => null,
                'status' => ''
            ];
        }

        foreach ($categories as $category) {
            if ($category->getDietWeek() !== 0) {
                $weeks[$i] = [
                    'week_nb' => $category->getDietWeek(),
                    'message' => 'Réintroduire : ' . $category->getName(),
                    'category_id' => $category->getId(),
                    'status' => ''
                ];
            }
            $i++;
        }

        return $weeks;
    }

    /**
     * Generate all required to display diet timeline per user
     * @param User $user
     * @param array $categories
     * @return array[]
     */
    public function generateTimeline(User $user, array $categories)
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

        $weeks = $this->generateWeeks($categories);

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