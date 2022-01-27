<?php

namespace App\Controller;

use App\Repository\CommandeMenuRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function scan(Request $request, CommandeRepository $commandeRepository, EntityManagerInterface $manager): Response
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

			if ($commande->getEtat() != 'commandé') {
				return $this->render('app/scan.html.twig', [
					'form' => $form->createView(),
					'commande' => null,
					'code' => $commande->getCode(),
					'alreadyScanned' => true
				]);
			}

			$plats = $commande->getPlats();
			for ($i = 0; $i < count($plats); $i++) {
				$plats[$i]['prepare'] = 1;
			}
			foreach ($commande->getCommandeMenus() as $commandeMenu) {
				$platsMenus = $commandeMenu->getPlats();
				for ($i = 0; $i < count($platsMenus); $i++) {
					$platsMenus[$i]['prepare'] = 1;
				}
				$commandeMenu->setPlats($platsMenus);
				$manager->persist($commandeMenu);
			}

			$commande->setPlats($plats);
			$commande->setEtat('en cours');
			$manager->persist($commande);
			$manager->flush();
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
	public function preparation(CommandeRepository $commandeRepository, CommandeMenuRepository $commandeMenuRepository, Request $request, EntityManagerInterface $manager): Response
	{
		$commandes = $commandeRepository->findAll();

		$form = $this->createFormBuilder()
			->add('commande_id', HiddenType::class)
			->add('commande_menu_id', HiddenType::class)
			->add('plat_id', HiddenType::class)
			->getForm();
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$commande_id = $form->get('commande_id')->getData();
			$commande_menu_id = $form->get('commande_menu_id')->getData();
			$plat_id = $form->get('plat_id')->getData();
			
			if ($commande_menu_id == null) {
				$commande = $commandeRepository->find($commande_id);

				$plats = $commande->getPlats();
				for ($i = 0; $i < count($plats); $i++) {
					if ($plat_id == $plats[$i]['id']) {
						$plats[$i]['prepare'] = 2;
						break;
					}
				}
				$commande->setPlats($plats);
				$manager->persist($commande);
			} else {
				$commandeMenu = $commandeMenuRepository->find($commande_menu_id);

				$plats = $commandeMenu->getPlats();
				for ($i = 0; $i < count($plats); $i++) {
					if ($plat_id == $plats[$i]['id']) {
						$plats[$i]['prepare'] = 2;
						break;
					}
				}
				$commandeMenu->setPlats($plats);
				$manager->persist($commandeMenu);
			}

			$termine1 = true;
			$termine2 = true;

			$commande = $commandeRepository->find($commande_id);
			$plats = $commande->getPlats();
			$termine1 = count(array_filter($plats, function($plat) { return $plat['prepare'] != 2; })) == 0;

			foreach ($commande->getCommandeMenus() as $commandeMenu) {
				$plats = $commandeMenu->getPlats();
				$termine2 = count(array_filter($plats, function($plat) { return $plat['prepare'] != 2; })) == 0;
				
				if ($termine2 == false) {
					break;
				}
			}

			if ($termine1 && $termine2) {
				$commande = $commandeRepository->find($commande_id);
				$commande->setEtat('terminé');
				$manager->persist($commande);
			}
			
			$manager->flush();
			$commandes = $commandeRepository->findAll();
		}

		return $this->render('app/preparation.html.twig', [
			'form' => $form->createView(),
			'commandes' => $commandes
		]);
	}
}
