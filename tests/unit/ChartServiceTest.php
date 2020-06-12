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
    private $symptom;
    private $categories;
    private $chartService;
    
    protected function _before()
    {
        // Create user with start and end dates
        $this->user = new User();
        $this->user->setStartDate(new DateTime());
        $startDate = clone $this->user->getStartDate();
        $this->user->setEndDate($startDate->add(new DateInterval('P56D')));

        // Create one symptom and add it twice on same day for user and 2 weeks after
        $this->symptom = new Symptom();
        $this->symptom->setName('MalPartout');

        $userSymptom = new UserSymptom();
        $userSymptom->setSymptom($this->symptom)->setUser($this->user);
        $userSymptom->setDate(new DateTime());

        $userSymptom2 = new UserSymptom();
        $userSymptom2->setSymptom($this->symptom)->setUser($this->user);
        $userSymptom2->setDate(new DateTime());

        $userSymptom3 = new UserSymptom();
        $userSymptom3->setSymptom($this->symptom)->setUser($this->user);
        $userSymptom3->setDate((new DateTime())->add(new DateInterval('P16D')));

        $this->user->addUserSymptom($userSymptom);
        $this->user->addUserSymptom($userSymptom2);
        $this->user->addUserSymptom($userSymptom3);

        // Check number of symptoms for user
        $userSymptoms = $this->user->getUserSymptoms();
        $this->assertEquals(3, count($userSymptoms));

        // Create categories and put them in an array
        for ($i = 3; $i <= 8; $i++) {
            $category = new Category();
            $category->setDietWeek($i);
            $category->setName('Les Trucs ' . $i);
            $this->categories[] = $category;
        }

        // Create fake category repository to instantiate ChartService
        $categoryRepository = $this->make(CategoryRepository::class);
        $this->chartService = new ChartService($categoryRepository);
    }

    protected function _after()
    {
    }

    // tests
    public function testGenerateDataPerDay()
    {
        $dataDaysChart = $this->chartService->generateDataPerDay($this->user);
        $this->assertEquals(date_format(new DateTime(), 'd/m/Y'), $dataDaysChart['labelDays'][0]);
        $this->assertEquals(2, $dataDaysChart['nbSymptomsPerDay'][0]);
    }

    public function testGenerateDataPerWeek()
    {
        $dataWeeksChart = $this->chartService->generateDataPerWeek($this->user, $this->categories);
        $this->assertEquals('3. Les Trucs 3', $dataWeeksChart['labelWeeks'][2]);
        $this->assertEquals(2, $dataWeeksChart['nbSymptomsPerWeek'][0]);
    }

    public function testGenerateDataPerWeekPerSymptom()
    {
        $data = $this->chartService->generateDataPerWeekPerSymptom($this->user, $this->symptom);
        $this->assertEquals(2, $data['nbSymptomsPerWeek'][0]);
    }

    public function testGenerateDataForDietWeeks()
    {
        $data = $this->chartService->generateDataForDietWeeks($this->user, $this->categories);
        $this->assertEquals(0, $data['weeks_data'][0]);
        $this->assertEquals(56, $data['weeks_data'][1]);
        $this->assertEquals('Vous êtes à la semaine 1 de votre régime !', $data['message']);
        $this->assertEquals(null, $data['category']);
    }

    public function testGenerateDataForCategories()
    {
        $data = $this->chartService->generateDataForCategories($this->user, $this->categories);
        $this->assertEquals('Les Trucs 3', $data['categories_labels'][0]);
        $this->assertEquals(1, $data['nbSymptomsPerWeek'][0]);
        $this->assertEquals('Les Trucs 3', $data['worst_category']->getName());
    }
}