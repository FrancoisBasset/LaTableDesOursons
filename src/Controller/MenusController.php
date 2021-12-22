<?php

namespace App\Controller;

use App\Repository\CategoriePlatRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusController extends AbstractController
{
    /**
	 * @Route("/menus", name="menus")
	 */
    public function index(MenuRepository $menuRepository, CategoriePlatRepository $categoriePlatRepository): Response
    {
		$menus = $menuRepository->findAll();
		$carte = $categoriePlatRepository->findCategoriesWithNoMenu();

        return $this->render('menus/index.html.twig', [
			'menus' => $menus,
			'carte' => $carte
		]);
    }
}