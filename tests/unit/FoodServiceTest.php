<?php namespace App\Tests;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\Symptom;
use App\Entity\User;
use App\Entity\UserFood;
use App\Entity\UserSymptom;
use App\Service\FoodService;
use App\Service\GenericService;
use App\Service\UserService;
use DateInterval;
use DateTime;

class FoodServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    private $userDietInProgress;
    private $food;
    private $foodService;
    private $categories;


    protected function _before()
    {
        // Create userDietInProgress with start and end dates
        $this->userDietInProgress = new User();
        $this->userDietInProgress->setStartDate(new DateTime());
        $startDate = clone $this->userDietInProgress->getStartDate();
        $this->userDietInProgress->setEndDate($startDate->add(new DateInterval('P56D')));

        // Create one symptom and add it twice on same day for userDietInProgress and 2 weeks after
        $this->food = new Food();
        $this->food->setName('BonManger');

        $userFood = new UserFood();
        $userFood->setFood($this->food)->setUser($this->userDietInProgress);
        $userFood->setDate(new DateTime());

        $userFood2 = new UserFood();
        $userFood2->setFood($this->food)->setUser($this->userDietInProgress);
        $userFood2->setDate(new DateTime());

        $userFood3 = new UserFood();
        $userFood3->setFood($this->food)->setUser($this->userDietInProgress);
        $userFood3->setDate((new DateTime())->add(new DateInterval('P16D')));

        $this->userDietInProgress->addUserFood($userFood);
        $this->userDietInProgress->addUserFood($userFood2);
        $this->userDietInProgress->addUserFood($userFood3);

        // Check number of symptoms for user
        $userFoods = $this->userDietInProgress->getUserFoods();
        $this->assertCount(3, $userFoods);

        // Create categories and put them in an array
        for ($i = 3; $i <= 8; $i++) {
            $category = new Category();
            $category->setDietWeek($i);
            $category->setName('Les Trucs ' . $i);
            $this->categories[] = $category;
        }

        // Create UserService and GenericService to instantiate SymptomService
        $userService = new UserService();
        $genericService = new GenericService();
        $this->foodService = new FoodService($userService, $genericService);
    }

    protected function _after()
    {
    }

    // tests
    public function testAssociateFoodsToDietWeeks()
    {
        // test for userDietInProgress
        $data = $this->foodService->associateFoodsToDietWeeks($this->userDietInProgress, $this->categories);
        $this->assertEquals($this->food, $data['1. Régime strict'][0]->getFood());
        $this->assertEquals($this->food, $data['3. Les Trucs 3'][0]->getFood());
    }
}