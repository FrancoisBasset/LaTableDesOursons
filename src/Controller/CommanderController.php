<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommanderController extends AbstractController
{
    /**
	 * @Route("/commander", name="commander")
	 */
    public function index(MenuRepository $menuRepository): Response
    {
		$menus = $menuRepository->findAll();

        return $this->render('commander/index.html.twig', [
			'menus' => $menus
		]);
    }
}
