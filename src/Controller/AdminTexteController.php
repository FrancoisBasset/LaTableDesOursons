<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Form\AdminTexteType;
use App\Repository\TexteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

		$texte = new Texte();
		$form = $this->createForm(AdminTexteType::class, $texte);
		$form->handleRequest($request);

		$form2 = $this->createFormBuilder()
			->add('position', HiddenType::class)
			->add('up', SubmitType::class, [
				'label' => 'Up'
			])
			->add('down', SubmitType::class, [
				'label' => 'Down'
			])
			->getForm();
		$form2->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$manager->persist($texte);
			$manager->flush();
			$textes = $texteRepository->findAll();
		}

		if ($form2->isSubmitted() && $form2->isValid()) {
			$position = intval($form2->get('position')->getData());

			if ($form2->get('up')->isClicked()) {
				foreach ($textes as $texte) {
					if ($texte->getPosition() == $position) {
						$texte->setPosition($position - 1);
					} else if ($texte->getPosition() == $position - 1) {
						$texte->setPosition($position);
					}
					$manager->persist($texte);
				}
			} else if ($form2->get('down')->isClicked()) {
				foreach ($textes as $texte) {
					if ($texte->getPosition() == $position) {
						$texte->setPosition($position + 1);
					} else if ($texte->getPosition() == $position + 1) {
						$texte->setPosition($position);
					}
					$manager->persist($texte);
				}
			}
			
			$manager->flush();
			
			$textes = $texteRepository->findAll();
		}

        return $this->render('admin_texte/index.html.twig', [
            'form' => $form->createView(),
			'form2' => $form2->createView(),
			'textes' => $textes
        ]);
    }
}