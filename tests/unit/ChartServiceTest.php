<?php namespace App\Tests;

use App\Entity\Category;
use App\Entity\Symptom;
use App\Entity\User;
use App\Entity\UserSymptom;
use App\Repository\CategoryRepository;
use App\Service\ChartService;
use DateInterval;
use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;

class ChartServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;
    private $user;
    private $chartService;
    
    protected function _before()
    {
        // Create user with start and end dates
        $this->user = new User();
        $this->user->setStartDate(new DateTime());
        $startDate = clone $this->user->getStartDate();
        $this->user->setEndDate($startDate->add(new DateInterval('P56D')));

        // Create one symptom and add it twice on same day for user
        $symptom = new Symptom();
        $userSymptom = new UserSymptom();
        $userSymptom->setSymptom($symptom)->setUser($this->user);
        $userSymptom->setDate(new DateTime());
        $userSymptom2 = new UserSymptom();
        $userSymptom2->setSymptom($symptom)->setUser($this->user);
        $userSymptom2->setDate(new DateTime());
        $this->user->addUserSymptom($userSymptom);
        $this->user->addUserSymptom($userSymptom2);

        // Check number of symptoms for user
        $userSymptoms = $this->user->getUserSymptoms();
        $this->assertEquals(2, count($userSymptoms));

        // Create fake category repository to instantiate ChartService
        $categoryRepository = $this->make(CategoryRepository::class);
        $this->chartService = new ChartService($categoryRepository);
    }

    protected function _after()
    {
    }

    // tests
    public function testDayDataChartService()
    {
        // Check results of ChartService GenerateDataPerDay
        $dataDaysChart = $this->chartService->generateDataPerDay($this->user);
        $this->assertEquals(date_format(new DateTime(), 'd/m/Y'), $dataDaysChart['labelDays'][0]);
        $this->assertEquals(2, $dataDaysChart['nbSymptomsPerDay'][0]);
    }

    public function testWeekDataChartService()
    {
        // Create a category and put it in an array
        $category = new Category();
        $category->setDietWeek(3);
        $category->setName('Les Trucs');

        $categories = [$category];

        // Check results of ChartService GenerateDataPerWeek
        $dataWeeksChart = $this->chartService->generateDataPerWeek($this->user, $categories);
        $this->assertEquals('3. Les Trucs', $dataWeeksChart['labelWeeks'][2]);
        $this->assertEquals(2, $dataWeeksChart['nbSymptomsPerWeek'][0]);
    }
}