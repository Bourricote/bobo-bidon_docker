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

        $data = $chartService->generateDataForDietWeeks($user, $categories);
        $weeksData = [0 => $data['done'], 1 => $data['left']];
        $message = $data['message'];
        $category = $data['category'];

        return $this->render('default/index.html.twig', [
            'weeks_data' => $weeksData,
            'message' => $message,
            'category' => $category,
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
