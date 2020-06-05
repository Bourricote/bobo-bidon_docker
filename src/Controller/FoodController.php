<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\FoodSearch;
use App\Form\FoodSearchType;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/food")
 */
class FoodController extends AbstractController
{
    const ITEMS_PER_PAGE = 30;

    /**
     * @Route("/", name="food_index_user", methods={"GET"})
     * @param FoodRepository $foodRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function userIndex(FoodRepository $foodRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new FoodSearch();
        $form = $this->createForm(FoodSearchType::class, $search);
        $form->handleRequest($request);
        $data = $foodRepository->findByFoodSearchQuery($search);

        $foods = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            self::ITEMS_PER_PAGE
        );

        return $this->render('food/index_public.html.twig', [
            'form' => $form->createView(),
            'foods' => $foods,
        ]);
    }

    /**
     * @Route("/admin", name="food_index", methods={"GET"})
     * @param FoodRepository $foodRepository
     * @param Request $request
     * @return Response
     */
    public function index(FoodRepository $foodRepository, Request $request): Response
    {
         return $this->render('food/index.html.twig', [
            'foods' => $foodRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    /**
     * @Route("/admin/new", name="food_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $food = new Food();
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($food);
            $entityManager->flush();

            return $this->redirectToRoute('food_index');
        }

        return $this->render('food/new.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="food_show", methods={"GET"})
     */
    public function show(Food $food): Response
    {
        return $this->render('food/show.html.twig', [
            'food' => $food,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="food_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Food $food): Response
    {
        $form = $this->createForm(FoodType::class, $food);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('food_index');
        }

        return $this->render('food/edit.html.twig', [
            'food' => $food,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="food_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Food $food): Response
    {
        if ($this->isCsrfTokenValid('delete'.$food->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($food);
            $entityManager->flush();
        }

        return $this->redirectToRoute('food_index');
    }
}
