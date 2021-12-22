<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusController extends AbstractController
{
    /**
	 * @Route("/menus", name="menus")
	 */
    public function index(): Response
    {
		$menus = [];//$menuRepository->findAll();

        return $this->render('menus/index.html.twig', [
			'menus' => $menus
		]);
    }
}
