<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommandeController extends AbstractController
{
	/**
	 * @Route("/admin/commande/liste", name="admin_commande_liste")
	 */
    public function index(CommandeRepository $commandeRepository): Response
    {
		$commandes = $commandeRepository->findAll();

        return $this->render('admin_commande/index.html.twig', [
            'commandes' => $commandes
        ]);
    }
}