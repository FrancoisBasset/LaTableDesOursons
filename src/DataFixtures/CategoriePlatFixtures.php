<?php

namespace App\DataFixtures;

use App\Entity\CategoriePlat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriePlatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$categories = [
			['Les Entrées', 'entrees_ours'],
			['Les Plats', 'plats_ours'],
			['Les Desserts', 'desserts_ours'],
			['Les Entrées', 'entrees_ourse'],
			['Les Plats', 'plats_ourse'],
			['Les Desserts', 'desserts_ourse'],

			['Les Entrées', 'carte_entrees'],
			['Les Plats', 'carte_plats'],
			['Les Desserts', 'carte_desserts'],
			['Les Boissons non-alcoolisés', 'carte_boissons_non_alcoolises'],
			['Les Boissons alcoolisés', 'carte_boissons_alcoolises']
		];

		foreach ($categories as $c) {
			$category = new CategoriePlat();
			$category->setNom($c[0]);
			$this->addReference($c[1], $category);
			$manager->persist($category);
		}

        $manager->flush();
    }
}
