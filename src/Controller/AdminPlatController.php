<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\AdminPlatType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPlatController extends AbstractController
{
	/**
	 * @Route("admin_plat_liste", name="admin_plat_liste")
	 */
	public function liste(PlatRepository $platRepository): Response
	{
		$plats = $platRepository->findAll();

		return $this->render('admin_plat/liste.html.twig', [
			'plats' => $plats
		]);
	}

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
			$plat = new Plat();
			$form = $this->createForm(AdminPlatType::class, $plat);
		}

        return $this->render('admin_plat/nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
