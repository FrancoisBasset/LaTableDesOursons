<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeMenu;
use App\Form\CommandeMenuType;
use App\Form\CommandeType;
use App\Repository\MenuRepository;
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
    public function index(Request $request, MenuRepository $menuRepository, EntityManagerInterface $manager, GenerationCodeCommande $generationCodeCommande, SessionInterface $sessionInterface): Response
    {
		if (!$sessionInterface->has('commandeMenus')) {
			$sessionInterface->set('commandeMenus', []);
		}
		$menus = $menuRepository->findAll();
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
			foreach ($form->get('plats')->getData() as $plat) {
				$prix += $plat->getPrix();
			}
			$commande->setPrix($prix);

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
			$menu = $form2->get('menu')->getData();
			$plats = [];

			foreach ($form2->get('plats')->getData() as $plat) {
				array_push($plats, [
					'nom' => $plat->getNom(),
					'prix' => $plat->getPrix()
				]);
			}

			$commandeMenu = new CommandeMenu();
			$commandeMenu->setMenu([
				'nom' => $menu->getNom(),
				'prix' => $menu->getPrix()
			]);
			$commandeMenu->setPlats($plats);
			
			array_push($commandeMenus, $commandeMenu);
			$sessionInterface->set('commandeMenus', $commandeMenus);
		}

        return $this->render('commander/index.html.twig', [
			'menus' => $menus,
			'form' => $form->createView(),
			'form2' => $form2->createView(),
			'commandeMenus' => $commandeMenus
		]);
    }
}
