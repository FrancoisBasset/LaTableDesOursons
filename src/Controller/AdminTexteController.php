<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Form\AdminTexteSelectType;
use App\Form\AdminTexteType;
use App\Repository\TexteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTexteController extends AbstractController
{
    /**
	 * @Route("/admin/texte", name="admin_texte")
	 */
    public function index(TexteRepository $texteRepository , Request $request, EntityManagerInterface $manager): Response
    {
		$textes = $texteRepository->findAll();

		$position = null;
		$form = $this->createForm(AdminTexteType::class);
		$form->handleRequest($request);

		$form2 = $this->createForm(AdminTexteSelectType::class);
		$form2->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if ($form->get('creer_texte')->isClicked()) {
				$texte = new Texte();
				$texte->setPosition(count($textes));
			} else if ($form->get('modifier_texte')->isClicked()) {
				$texte = $texteRepository->find($form->get('id')->getData());
				$position = intval($form->get('position')->getData());
			}
			
			$texte->setTexteFr($form->get('texte_fr')->getData());
			$texte->setTexteEn($form->get('texte_en')->getData());
			$manager->persist($texte);
			$manager->flush();
			$textes = $texteRepository->findAll();

			$texte = new Texte();
			$form = $this->createForm(AdminTexteType::class, $texte);
		}

		if ($form2->isSubmitted() && $form2->isValid()) {
			$position = intval($form2->get('position')->getData());

			if ($form2->get('up')->isClicked() && $position != 0) {
				foreach ($textes as $texte) {
					if ($texte->getPosition() == $position) {
						$texte->setPosition($position - 1);
					} else if ($texte->getPosition() == $position - 1) {
						$texte->setPosition($position);
					}
					$manager->persist($texte);
				}
				$position--;
			} else if ($form2->get('down')->isClicked() && $position != count($textes) - 1) {
				foreach ($textes as $texte) {
					if ($texte->getPosition() == $position) {
						$texte->setPosition($position + 1);
					} else if ($texte->getPosition() == $position + 1) {
						$texte->setPosition($position);
					}
					$manager->persist($texte);
				}
				$position++;
			} else if ($form2->get('remove')->isClicked()) {
				$texte = $texteRepository->findOneBy([
					'position' => $position
				]);
				$manager->remove($texte);
				$manager->flush();

				$textesOrder = $texteRepository->findAll();
				$i = 0;
				foreach ($textesOrder as $texte) {
					$texte->setPosition($i);
					$manager->persist($texte);
					
					$i++;
				}
				$position = null;
			}
			
			$manager->flush();
			
			$textes = $texteRepository->findAll();
		}

        return $this->render('admin_texte/index.html.twig', [
            'form' => $form->createView(),
			'form2' => $form2->createView(),
			'textes' => $textes,
			'position' => $position
        ]);
    }
}