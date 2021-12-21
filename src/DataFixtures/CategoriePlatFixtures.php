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
		$this->addReference("entrees", $category);
		$manager->persist($category);

		$category = new CategoriePlat();
		$category->setNom('Les Plats');
		$this->addReference("plats", $category);
		$manager->persist($category);

		$category = new CategoriePlat();
		$category->setNom('Les Desserts');
		$this->addReference("desserts", $category);
		$manager->persist($category);

        $manager->flush();
    }
}
