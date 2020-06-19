<?php


namespace App\Service;


use DateInterval;
use DateTime;

class GenericService
{
    const DAYS_PER_WEEK = 7;
    const NB_WEEKS_DIET = 8;
    const NB_DAYS_DIET = self::NB_WEEKS_DIET * 7;

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
                $labelWeeks[] = $i + 1 . '. Régime strict';
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
     * Associate dietWeeks labels to user data (symptoms / foods)
     * @param array $labelWeeks
     * @param $userData
     * @param DateTime $startDate
     * @return array[]
     */
    public function associate(array $labelWeeks, $userData, DateTime $startDate)
    {
        $oldDate = clone $startDate;
        $weeksWithData = [];

        foreach ($labelWeeks as $week) {
            $weeksWithData[$week] = [];
            $newDate = $startDate->add(new DateInterval('P7D'));
            foreach ($userData as $userDatum) {
                if ($userDatum->getDate() >= $oldDate && $userDatum->getDate() < $newDate) {
                    $weeksWithData[$week][] = $userDatum;
                }
            }
            $oldDate = clone $newDate;
        }

        return $weeksWithData;
    }
}