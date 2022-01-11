<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\AdminPlatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPlatController extends AbstractController
{
	/**
	 * @Route("/admin/plat/nouveau", name="admin_plat_nouveau")
	 */
    public function nouveau(Request $request, EntityManagerInterface $manager): Response
    {
		$plat = new Plat();
		$form = $this->createForm(AdminPlatType::class, $plat);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$manager->persist($plat);
			$manager->flush();
		}

        return $this->render('admin_plat/nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
