<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
	 * @Route("/admin", name="admin")
	 */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

	/**
	 * @Route("changePassword", name="admin_changePassword")
	 */
	public function changePassword(Request $request, EntityManagerInterface $manager, AdminRepository $adminRepository, UserPasswordHasherInterface $encoder): Response
	{
		$form = $this->createForm(ChangePasswordType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$admin = $adminRepository->find(1);
			$admin->setPassword($encoder->hashPassword($admin, $form->get('password')->getData()));
			$manager->persist($admin);
			$manager->flush();
		}

		return $this->render('admin/changePassword.html.twig', [
			'form' => $form->createView()
		]);
	}
}