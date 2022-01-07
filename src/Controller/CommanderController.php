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

		$commande = new Commande();
		$commande->setEtat('commandé');
		$commande->setCode($generationCodeCommande->generate());
		$form = $this->createForm(CommandeType::class, $commande);

		$commandeMenu = new CommandeMenu();
		$form2 = $this->createForm(CommandeMenuType::class, $commandeMenu);

		$form->handleRequest($request);
		$form2->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			foreach ($commandeMenus as $commandeMenu) {
				$manager->persist($commandeMenu);
				$commande->addCommandeMenu($commandeMenu);
			}

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
			array_push($commandeMenus, $commandeMenu);
			$sessionInterface->set('commandeMenus', $commandeMenus);
		}

        return $this->render('commander/index.html.twig', [
			'menus' => $menus,
			'commande' => $commande,
			'form' => $form->createView(),
			'form2' => $form2->createView(),
			'commandeMenus' => $commandeMenus
		]);
    }
}
