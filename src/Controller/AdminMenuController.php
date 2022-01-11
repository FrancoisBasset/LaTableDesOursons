<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\AdminMenuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMenuController extends AbstractController
{
	/**
	 * @Route("/admin/menu", name="admin_menu_nouveau")
	 */
    public function nouveau(Request $request, EntityManagerInterface $manager): Response
    {
		$menu = new Menu();
		$form = $this->createForm(AdminMenuType::class, $menu);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			foreach ($form->get('categories')->getData() as $category) {
				$menu->addCategory($category);
			}

			$manager->persist($menu);
			$manager->flush();
			$menu = new Menu();
			$form = $this->createForm(AdminMenuType::class, $menu);
		}
        
		return $this->render('admin_menu/nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
