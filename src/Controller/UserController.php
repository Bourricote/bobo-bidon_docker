<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserSymptom;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/charts/{user}", name="charts", methods={"GET"})
     * @param User $user
     * @return Response
     * @throws \Exception
     */
    public function userCharts(User $user): Response
    {
        $today = new DateTime();
        $userSymptoms = $user->getUserSymptoms();

        if (!$user->getStartDate()) {
            return $this->redirectToRoute('user_index');
        }

        // Chart Symptoms per day
        $startDate = $user->getStartDate();
        $startDateDays = clone $startDate;

        $nbDays = $startDateDays->diff($today)->days;

        $symptomsPerDay = [];

        $dataDays = [];
        for ($i = 0; $i <= $nbDays; $i++) {
            if ( $i!= 0){
                $newDate = $startDateDays->add(new DateInterval('P1D'));
            } else {
                $newDate = $startDateDays;
            }
            $dataDays[] = date_format($newDate, 'd/m/Y');
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if (date_format($userSymptom->getDate(), 'd/m/Y') == date_format($newDate, 'd/m/Y')) {
                    $j ++ ;
                }
            }
            $symptomsPerDay[] = $j;
        }

        // Chart Symptoms per week
        $startDateWeeks = $user->getStartDate();

        $nbWeeks = (($startDateWeeks->diff($today)->days) / 7) + 1 ;

        $symptomsPerWeek = [];

        $dataWeeks = [];
        $oldDate = clone $startDateWeeks;
        for ($i = 0; $i <= $nbWeeks; $i++) {
            $newDate = $startDateWeeks->add(new DateInterval('P7D'));

            $dataWeeks[] = date_format($newDate, 'd/m/Y');
            $j = 0;
            foreach ($userSymptoms as $userSymptom) {
                if ($userSymptom->getDate() >= $oldDate && $userSymptom->getDate() < $newDate) {
                    $j ++ ;
                }
            }
            $symptomsPerWeek[] = $j;
            $oldDate = clone $newDate;
        }

        return $this->render('symptom/charts.html.twig', [
            'data_symptoms_per_day' => $symptomsPerDay,
            'data_days' => $dataDays,
            'data_symptoms_per_week' => $symptomsPerWeek,
            'data_weeks' => $dataWeeks,
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
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
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
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
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
