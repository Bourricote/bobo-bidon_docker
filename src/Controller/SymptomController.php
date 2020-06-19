<?php

namespace App\Controller;

use App\Entity\Symptom;
use App\Entity\User;
use App\Entity\UserSymptom;
use App\Form\AddSymptomsType;
use App\Form\SymptomType;
use App\Repository\CategoryRepository;
use App\Repository\SymptomRepository;
use App\Service\SymptomService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/symptom")
 */
class SymptomController extends AbstractController
{

    /**
     * @Route("/addsymptom/{user}", name="add_user_symptom", methods={"GET","POST"})
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function addSymptom(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(AddSymptomsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $date = $data['date'];
            $time = $data['time'];
            $symptoms = $data['symptoms'];

            foreach ($symptoms as $symptom) {
                $userSymptom = new UserSymptom();
                $userSymptom->setUser($user);
                $userSymptom->setDate($date);
                $userSymptom->setTime($time);
                $userSymptom->setSymptom($symptom);

                $entityManager->persist($userSymptom);
            }

            $entityManager->flush();
            $this->addFlash(
                'primary',
                'Vos changements ont été sauvegardés !'
            );

            return $this->redirectToRoute('charts', ['user' => $user->getId()]);
        }

            return $this->render('symptom/add_user_symptom.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showsymptom/{user}", name="show_user_symptom", methods={"GET"})
     * @param User $user
     * @param SymptomService $symptomService
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function showUserSymptoms(User $user, SymptomService $symptomService, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $weeksWithSymptoms = $symptomService->associateSymptomsToDietWeeks($user, $categories);

        return $this->render('symptom/show_user_symptom.html.twig', [
            'weeksWithSymptoms' => $weeksWithSymptoms,
        ]);
    }

    /**
     * @Route("/admin", name="symptom_index", methods={"GET"})
     * @param SymptomRepository $symptomRepository
     * @return Response
     */
    public function index(SymptomRepository $symptomRepository): Response
    {
        return $this->render('symptom/index.html.twig', [
            'symptoms' => $symptomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="symptom_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $symptom = new Symptom();
        $form = $this->createForm(SymptomType::class, $symptom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($symptom);
            $entityManager->flush();

            return $this->redirectToRoute('symptom_index');
        }

        return $this->render('symptom/new.html.twig', [
            'symptom' => $symptom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="symptom_show", methods={"GET"})
     * @param Symptom $symptom
     * @return Response
     */
    public function show(Symptom $symptom): Response
    {
        return $this->render('symptom/show.html.twig', [
            'symptom' => $symptom,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="symptom_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Symptom $symptom
     * @return Response
     */
    public function edit(Request $request, Symptom $symptom): Response
    {
        $form = $this->createForm(SymptomType::class, $symptom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('symptom_index');
        }

        return $this->render('symptom/edit.html.twig', [
            'symptom' => $symptom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="symptom_delete", methods={"DELETE"})
     * @param Request $request
     * @param Symptom $symptom
     * @return Response
     */
    public function delete(Request $request, Symptom $symptom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$symptom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($symptom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('symptom_index');
    }
}
