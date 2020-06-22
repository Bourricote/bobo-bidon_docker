<?php namespace App\Tests;

use App\Entity\Category;
use App\Entity\Symptom;
use App\Entity\User;
use App\Entity\UserSymptom;
use App\Repository\CategoryRepository;
use App\Service\SymptomService;
use App\Service\GenericService;
use App\Service\UserService;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Persistence\ManagerRegistry;

class SymptomeServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    private $userDietInProgress;
    private $userDietNotStarted;
    private $userDietEnded;
    private $symptom;
    private $categories;
    private $symptomService;
    
    protected function _before()
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

        // Create one symptom and add it twice on same day for userDietInProgress and 2 weeks after
        $this->symptom = new Symptom();
        $this->symptom->setName('MalPartout');

        $userSymptom = new UserSymptom();
        $userSymptom->setSymptom($this->symptom)->setUser($this->userDietInProgress);
        $userSymptom->setDate(new DateTime());

        $userSymptom2 = new UserSymptom();
        $userSymptom2->setSymptom($this->symptom)->setUser($this->userDietInProgress);
        $userSymptom2->setDate(new DateTime());

        $userSymptom3 = new UserSymptom();
        $userSymptom3->setSymptom($this->symptom)->setUser($this->userDietInProgress);
        $userSymptom3->setDate((new DateTime())->add(new DateInterval('P16D')));

        $this->userDietInProgress->addUserSymptom($userSymptom);
        $this->userDietInProgress->addUserSymptom($userSymptom2);
        $this->userDietInProgress->addUserSymptom($userSymptom3);

        // Check number of symptoms for user
        $userSymptoms = $this->userDietInProgress->getUserSymptoms();
        $this->assertCount(3, $userSymptoms);

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
        $this->symptomService = new SymptomService($userService, $genericService);
    }

    protected function _after()
    {
    }

    // tests
    public function testGenerateDataPerDay()
    {
        // test for userDietInProgress
        $data = $this->symptomService->generateDataPerDay($this->userDietInProgress);
        $this->assertEquals(date_format(new DateTime(), 'd/m/Y'), $data['labelDays'][0]);
        $this->assertEquals(2, $data['nbSymptomsPerDay'][0]);

        // test for userDietNotStarted
        $data = $this->symptomService->generateDataPerDay($this->userDietNotStarted);
        $this->assertEquals(null, $data);
    }

    public function testGenerateDataPerWeek()
    {
        // test for userDietInProgress
        $data = $this->symptomService->generateDataPerWeek($this->userDietInProgress, $this->categories);
        $this->assertEquals('3. Les Trucs 3', $data['labelWeeks'][2]);
        $this->assertEquals(2, $data['nbSymptomsPerWeek'][0]);

        // test for userDietNotStarted
        $data = $this->symptomService->generateDataPerWeek($this->userDietNotStarted, $this->categories);
        $this->assertEquals(null, $data);
    }

    public function testGenerateDataPerWeekPerSymptom()
    {
        // test for userDietInProgress
        $data = $this->symptomService->generateDataPerWeekPerSymptom($this->userDietInProgress, $this->symptom);
        $this->assertEquals(2, $data['nbSymptomsPerWeek'][0]);

        // test for userDietNotStarted
        $data = $this->symptomService->generateDataPerWeekPerSymptom($this->userDietNotStarted, $this->symptom);
        $this->assertEquals(null, $data);
    }

    public function testGenerateDataForDietWeeks()
    {
        // test for userDietInProgress
        $data1 = $this->symptomService->generateDataForDietWeeks($this->userDietInProgress, $this->categories);
        $this->assertEquals(0, $data1['days_data'][0]);
        $this->assertEquals(56, $data1['days_data'][1]);
        $this->assertEquals('Vous êtes à la semaine 1 de votre régime !', $data1['message']);
        $this->assertEquals(null, $data1['category']);

        // test for userDietNotStarted
        $data2 = $this->symptomService->generateDataForDietWeeks($this->userDietNotStarted, $this->categories);
        $this->assertEquals(0, $data2['days_data'][0]);
        $this->assertEquals(56, $data2['days_data'][1]);
        $this->assertEquals('Vous n\'avez pas commencé votre régime !', $data2['message']);
        $this->assertEquals(null, $data2['category']);

        // test for userDietEnded
        $data3 = $this->symptomService->generateDataForDietWeeks($this->userDietEnded, $this->categories);
        $this->assertEquals(56, $data3['days_data'][0]);
        $this->assertEquals(0, $data3['days_data'][1]);
        $this->assertEquals('Vous avez fini votre régime !', $data3['message']);
        $this->assertEquals(null, $data3['category']);
    }

    public function testGenerateDataForCategories()
    {
        // test for userDietInProgress
        $data = $this->symptomService->generateDataForCategories($this->userDietInProgress, $this->categories);
        $this->assertEquals('Les Trucs 3', $data['categories_labels'][0]);
        $this->assertEquals(1, $data['nbSymptomsPerWeek'][0]);
        $this->assertEquals('Les Trucs 3', $data['worst_category']->getName());

        // test for userDietNotStarted
        $data = $this->symptomService->generateDataForCategories($this->userDietNotStarted, $this->categories);
        $this->assertEquals(null, $data);
    }
}