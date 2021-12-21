<?php

namespace App\DataFixtures;

use App\Entity\CategoriePlat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriePlatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$category = new CategoriePlat();
		$category->setNom('Les Entrées');
		$manager->persist($category);

		$category = new CategoriePlat();
		$category->setNom('Les Plats');
		$manager->persist($category);

		$category = new CategoriePlat();
		$category->setNom('Les Desserts');
		$manager->persist($category);

        $manager->flush();
    }
}
