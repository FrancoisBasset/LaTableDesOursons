<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeMenu;
use App\Form\CommandeMenuType;
use App\Form\CommandeType;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use App\Service\GenerationCodeCommande;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommanderController extends AbstractController
{
    /**
	 * @Route("/commander", name="commander", methods={"GET", "POST"})
	 */
    public function index(Request $request, MenuRepository $menuRepository, PlatRepository $platRepository, EntityManagerInterface $manager, GenerationCodeCommande $generationCodeCommande, SessionInterface $sessionInterface): Response
    {
		if (!$sessionInterface->has('commandeMenus')) {
			$sessionInterface->set('commandeMenus', []);
		}
		$commandeMenus = $sessionInterface->get('commandeMenus');

		$form = $this->createForm(CommandeType::class, null);

		$form2 = $this->createForm(CommandeMenuType::class, null);

		$form->handleRequest($request);
		$form2->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$commande = new Commande();
			$commande->setPrenom($form->get('prenom')->getData());
			$commande->setNom($form->get('nom')->getData());
			$commande->setEtat('commandé');
			$commande->setCode($generationCodeCommande->generate());

			$prix = 0;
			foreach ($commandeMenus as $commandeMenu) {
				$prix += $commandeMenu->getMenu()['prix'];
				
				$manager->persist($commandeMenu);
				$commande->addCommandeMenu($commandeMenu);
			}
			$plats = [];
			foreach (explode(', ', $form->get('plats')->getData()) as $id_plat) {
				$plat = $platRepository->find($id_plat);
				array_push($plats, $plat->jsonSerialize());
				$prix += $plat->getPrix();
			}
			$commande->setPrix($prix);
			$commande->setPlats($plats);

			$manager->persist($commande);
			$manager->flush();
			$sessionInterface->clear();

			$result = Builder::create()
				->writer(new PngWriter())
				->data($commande->getCode())
				->encoding(new Encoding('UTF-8'))
				->size(300)
				->margin(10)
				->roundBlockSizeMode(new RoundBlockSizeModeMargin())
				->labelText($commande->getCode())
				->labelFont(new NotoSans(20))
				->labelAlignment(new LabelAlignmentCenter())
				->build();

			return $this->render('commander/qrcode.html.twig', [
				'qrcode' => $result->getDataUri()
			]);
		}

		if ($form2->isSubmitted() && $form2->isValid()) {
			$menu = $menuRepository->find($form2->get('menu')->getData());
			$plats_menu = [];

			foreach (explode(',', $form2->get('plats')->getData()) as $id_plat) {
				$plat = $platRepository->find($id_plat);
				array_push($plats_menu, [
					'nom' => $plat->getNom(),
					'prix' => $plat->getPrix(),
					'image' => $plat->getImage()
				]);
			}

			$commandeMenu = new CommandeMenu();
			$commandeMenu->setMenu([
				'nom' => $menu->getNom(),
				'prix' => $menu->getPrix()
			]);
			$commandeMenu->setPlats($plats_menu);
			
			array_push($commandeMenus, $commandeMenu);

			$sessionInterface->set('commandeMenus', $commandeMenus);
		}

		$total_menus = array_reduce($commandeMenus, function($total, $commandeMenu) {
			return $total + $commandeMenu->getMenu()['prix'];
		}, 0);

        return $this->render('commander/index.html.twig', [
			'menus' => $menuRepository->findAll(),
			'plats' => $platRepository->findAll(),
			'form' => $form->createView(),
			'form2' => $form2->createView(),
			'commandeMenus' => $commandeMenus,
			'total_menus' => $total_menus
		]);
    }
}
