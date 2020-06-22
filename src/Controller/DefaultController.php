<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Service\SymptomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home/{user}", name="home")
     * @param User $user
     * @param SymptomService $chartService
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    public function home(
        User $user,
        SymptomService $chartService,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response
    {
        $categories = $categoryRepository->findAll();

        // First dashboard card: diet progression
        $dashboard1 = $chartService->generateDataForDietWeeks($user, $categories);

        // Second dashboard card: worst category
        $dashboard2 = $chartService->generateDataForCategories($user, $categories);

        // Boolean to know if First connection modal should show
        $fromRegistration = false;
        if ($request->getSession()->get('fromRegistration')) {
            $fromRegistration = true;
            $session = $request->getSession();
            $session->set('fromRegistration', false);
        }

        return $this->render('home.html.twig', [
            'dashboard1' => $dashboard1,
            'dashboard2' => $dashboard2,
            'fromRegistration' => $fromRegistration
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function adminPage(): Response
    {
        return $this->render('admin.html.twig');
    }
}
