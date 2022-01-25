<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
	/**
	 * @Route("/app/scan", name="app_scan")
	 */
    public function scan(Request $request, CommandeRepository $commandeRepository): Response
    {
		$form = $this->createFormBuilder()
			->add('code', HiddenType::class)
			->getForm();
		$form->handleRequest($request);

		$commande = null;

		if ($form->isSubmitted() && $form->isValid()) {
			$code = $form->get('code')->getData();

			$commande = $commandeRepository->findOneBy([
				'code' => $code
			]);
		}

        return $this->render('app/scan.html.twig', [
			'form' => $form->createView(),
			'commande' => $commande
		]);
    }

	/**
	 * @Route("/app/commandes", name="app_commandes")
	 */
	public function commandes(CommandeRepository $commandeRepository): Response
	{
		$commandes = $commandeRepository->findAll();

		return $this->render('app/commandes.html.twig', [
			'commandes' => $commandes
		]);
	}

	/**
	 * @Route("/app/preparation", name="app_preparation")
	 */
	public function preparation(): Response
	{
		return $this->render('app/preparation.html.twig');
	}
}
