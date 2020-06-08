<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Service\ChartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home/{user}", name="home")
     * @param User $user
     * @param ChartService $chartService
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(User $user, ChartService $chartService, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        // First dashboard card: diet progression
        $dashboard1 = $chartService->generateDataForDietWeeks($user, $categories);

        // Second dashboard card: worst category
        $dashboard2 = $chartService->generateDataForCategories($user, $categories);

        return $this->render('default/index.html.twig', [
            'dashboard1' => $dashboard1,
            'dashboard2' => $dashboard2,
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
