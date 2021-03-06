<?php

namespace App\Controller;

use App\Entity\CategoriePlat;
use App\Form\AdminCategorieType;
use App\Repository\CategoriePlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController
{
	/**
	 * @Route("/admin/categorie/liste", name="admin_categorie_liste")
	 */
	public function liste(CategoriePlatRepository $categoriePlatRepository): Response
	{
		$categories = $categoriePlatRepository->findAll();

		return $this->render('admin_categorie/liste.html.twig', [
			'categories' => $categories
		]);
	}

    /**
	 * @Route("/admin/categorie/nouveau", name="admin_categorie_nouveau")
	 */
    public function nouveau(Request $request, EntityManagerInterface $manager): Response
    {
		$categorie = new CategoriePlat();
		$form = $this->createForm(AdminCategorieType::class, $categorie);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$manager->persist($categorie);
			$manager->flush();
			$categorie = new CategoriePlat();
			$form = $this->createForm(AdminCategorieType::class, $categorie);
		}

        return $this->render('admin_categorie/nouveau.html.twig', [
			'form' => $form->createView()
		]);
    }
}
