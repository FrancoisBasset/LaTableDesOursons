<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$menu = new Menu();
		$menu->setNom("Menu de l'Ours");
		$menu->setPrix(22.50);
		$manager->persist($menu);

		$menu = new Menu();
		$menu->setNom("Menu de l'Ourse");
		$menu->setPrix(20.80);
		$manager->persist($menu);

        $manager->flush();
    }
}
