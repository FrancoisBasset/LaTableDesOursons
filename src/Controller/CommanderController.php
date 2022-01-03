<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\MenuRepository;
use App\Service\GenerationCodeCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommanderController extends AbstractController
{
    /**
	 * @Route("/commander", name="commander", methods={"GET", "POST"})
	 */
    public function index(Request $request, MenuRepository $menuRepository, EntityManagerInterface $manager, GenerationCodeCommande $generationCodeCommande): Response
    {
		$menus = $menuRepository->findAll();

		$commande = new Commande();
		$commande->setEtat('commandé');
		$commande->setCode($generationCodeCommande->generate());
		$form = $this->createForm(CommandeType::class, $commande);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$manager->persist($commande);
			$manager->flush();

			return $this->redirectToRoute('accueil');
		}

        return $this->render('commander/index.html.twig', [
			'menus' => $menus,
			'form' => $form->createView()
		]);
    }
}
