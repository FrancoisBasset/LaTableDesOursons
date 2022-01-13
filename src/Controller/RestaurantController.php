<?php

namespace App\Controller;

use App\Repository\TexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
	 * @Route("/restaurant", name="restaurant")
	 */
    public function index(TexteRepository $texteRepository): Response
    {
		$textes = $texteRepository->findAll();

        return $this->render('restaurant/index.html.twig', [
			'textes' => $textes
		]);
    }
}
