<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\SymptomRepository;
use App\Repository\UserRepository;
use App\Service\ChartService;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $symptomRepository;
    private $categoryRepository;

    public function __construct(SymptomRepository $symptomRepository, CategoryRepository $categoryRepository)
    {
        $this->symptomRepository = $symptomRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/charts/{user}", name="charts", methods={"GET"})
     * @param User $user
     * @param ChartService $chartService
     * @return Response
     */
    public function userCharts(User $user, ChartService $chartService): Response
    {
        $allSymptoms = $this->symptomRepository->findAll();
        $categories = $this->categoryRepository->findAll();

        if (!$user->getStartDate()) {
            $this->addFlash(
                'error',
                'Vous devez renseigner une date de début de régime !'
            );
            return $this->redirectToRoute('home');
        }

        $dataDaysChart = $chartService->generateDataPerDay($user);
        $labelsDays = $dataDaysChart['labelDays'];
        $nbSymptomsPerDay = $dataDaysChart['nbSymptomsPerDay'];

        $dataWeeksChart = $chartService->generateDataPerWeek($user, $categories);
        $labelWeeks = $dataWeeksChart['labelWeeks'];
        $nbSymptomsPerWeek = $dataWeeksChart['nbSymptomsPerWeek'];

        return $this->render('symptom/charts.html.twig', [
            'all_symptoms' => $allSymptoms,
            'nb_symptoms_per_day' => $nbSymptomsPerDay,
            'label_days' => $labelsDays,
            'nb_symptoms_per_week' => $nbSymptomsPerWeek,
            'label_weeks' => $labelWeeks,
        ]);
    }

    /**
     * @Route("/charts/symptom", name="chart_symptom", methods={"GET", "POST"})
     * @param ChartService $chartService
     * @return Response
     */
    public function userChartPerSymptom(ChartService $chartService): Response
    {
        $user = $this->getUser();

        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $symptomId = $obj->symptom;
        $symptom = $this->symptomRepository->findOneBy(['id' => $symptomId]);

        $dataWeeksChart = $chartService->generateDataPerWeekPerSymptom($user, $symptom);
        $nbSymptomsPerWeek = $dataWeeksChart['nbSymptomsPerWeek'];

        return $this->json([
            'symptoms' => $nbSymptomsPerWeek,
        ]);
    }

    /**
     * @Route("/profile/{user}", name="profile", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function showProfile(User $user): Response
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{user}/editprofile", name="edit_profile", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function editProfile(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('startDate')->getData()) {
                $startDate = clone $form->get('startDate')->getData();
                $endDate = $startDate->add(new DateInterval('P56D'));
                $user->setEndDate($endDate);
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'primary',
                'Vos changements ont été sauvegardés !'
            );

            return $this->redirectToRoute('profile', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('user/edit_profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showsymptom", name="show_user_symptom", methods={"GET"})
     * @return Response
     */
    public function showUserSymptoms(): Response
    {
        return $this->render('symptom/show_user_symptom.html.twig');
    }

    /**
     * @Route("/admin", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/{user}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
