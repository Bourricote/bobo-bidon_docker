<?php namespace App\Tests;
use App\Entity\Category;
use App\Entity\User;
use App\Service\GenericService;
use App\Service\TimelineService;
use App\Service\UserService;
use DateInterval;
use DateTime;
use DateTimeImmutable;

class TimelineServiceTest extends \Codeception\Test\Unit
{
    private $userDietInProgress;
    private $userDietNotStarted;
    private $userDietEnded;
    private $categories;
    private $timelineService;

    public function _before()
    {
        // Create userDietInProgress with start and end dates
        $this->userDietInProgress = new User();
        $this->userDietInProgress->setStartDate(new DateTime());
        $startDate = clone $this->userDietInProgress->getStartDate();
        $this->userDietInProgress->setEndDate($startDate->add(new DateInterval('P56D')));

        // Create userDietNotStarted with no dates
        $this->userDietNotStarted = new User();

        // Create userDietEnded with end date in the past
        $this->userDietEnded = new User();
        $today = new DateTimeImmutable();
        $this->userDietEnded->setStartDate($today->sub(new DateInterval('P58D')));
        $this->userDietEnded->setEndDate($today->sub(new DateInterval('P2D')));

        // Create categories and put them in an array
        for ($i = 3; $i <= 8; $i++) {
            $category = new Category();
            $category->setDietWeek($i);
            $category->setName('Les Trucs ' . $i);
            $this->categories[] = $category;
        }

        // Create UserService and GenericService to instantiate TimelineService
        $userService = new UserService();
        $genericService = new GenericService();
        $this->timelineService = new TimelineService($userService, $genericService);
    }

    // tests
    public function testGenerateTimeline()
    {
        // test for userDietInProgress
        $data1 = $this->timelineService->generateTimeline($this->userDietInProgress, $this->categories);

        $this->assertEquals(1, $data1[1]['week_nb']);
        $this->assertEquals(null, $data1[1]['category_id']);
        $this->assertEquals('Régime strict sans FODMAPs', $data1[1]['message']);
        $this->assertEquals('in-progress', $data1[1]['status']);

        $this->assertEquals(8, $data1[8]['week_nb']);
        $this->assertEquals(null, $data1[8]['category_id']);
        $this->assertEquals('Réintroduire : Les Trucs 8', $data1[8]['message']);
        $this->assertEquals('future', $data1[8]['status']);

        // test for userDietNotStarted
        $data2 = $this->timelineService->generateTimeline($this->userDietNotStarted, $this->categories);

        $this->assertEquals(1, $data2[1]['week_nb']);
        $this->assertEquals(null, $data2[1]['category_id']);
        $this->assertEquals('Régime strict sans FODMAPs', $data2[1]['message']);
        $this->assertEquals('future', $data2[1]['status']);

        $this->assertEquals(8, $data2[8]['week_nb']);
        $this->assertEquals(null, $data2[8]['category_id']);
        $this->assertEquals('Réintroduire : Les Trucs 8', $data2[8]['message']);
        $this->assertEquals('future', $data2[8]['status']);

        // test for userDietEnded
        $data3 = $this->timelineService->generateTimeline($this->userDietEnded, $this->categories);

        $this->assertEquals(1, $data3[1]['week_nb']);
        $this->assertEquals(null, $data3[1]['category_id']);
        $this->assertEquals('Régime strict sans FODMAPs', $data3[1]['message']);
        $this->assertEquals('completed', $data3[1]['status']);

        $this->assertEquals(8, $data3[8]['week_nb']);
        $this->assertEquals(null, $data3[8]['category_id']);
        $this->assertEquals('Réintroduire : Les Trucs 8', $data3[8]['message']);
        $this->assertEquals('completed', $data3[8]['status']);
    }
}
