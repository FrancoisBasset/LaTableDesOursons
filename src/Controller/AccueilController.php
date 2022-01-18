<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
	 * @Route("/", name="accueil", methods={"GET"})
	 */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig');
    }

	/**
	 * @Route("/changeLanguage", name="changeLanguage", methods={"GET"})
	 */
	public function changeLanguage(Request $request): Response
	{
		$lang = $request->query->get('language');

		$request->getSession()->set('_locale', $lang);

		return $this->redirect($request->headers->get('referer'));
	}
}
