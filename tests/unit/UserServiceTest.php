<?php namespace App\Tests;

use App\Entity\User;
use App\Service\UserService;
use DateInterval;
use DateTime;
use DateTimeImmutable;

class UserServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    private $userDietInProgress;
    private $userDietNotStarted;
    private $userService;
    private $today;
    private $futureDate;
    
    protected function _before()
    {
        // Create dates
        $this->today = new DateTimeImmutable();
        $this->futureDate = $this->today->add(new DateInterval('P56D'));

        // Create userDietInProgress with start and end dates
        $this->userDietInProgress = new User();
        $this->userDietInProgress->setStartDate($this->today);
        $this->userDietInProgress->setEndDate($this->futureDate);

        // Create userDietNotStarted with no dates
        $this->userDietNotStarted = new User();

        $this->userService = new UserService();
    }

    protected function _after()
    {
    }

    // tests
    public function testUserHasStartedDiet()
    {
        // test for userDietInProgress
        $hasStarted = $this->userService->userHasStartedDiet($this->userDietInProgress);
        $this->assertTrue($hasStarted);

        // test for userDietNotStarted
        $hasStarted = $this->userService->userHasStartedDiet($this->userDietNotStarted);
        $this->assertFalse($hasStarted);
    }

    public function testGetUserDietDates()
    {
        // test for userDietInProgress
        $dates = $this->userService->getUserDietDates($this->userDietInProgress);
        $this->assertEquals($this->today, $dates['startDate']);
        $this->assertEquals($this->futureDate, $dates['endDate']);

    }
}