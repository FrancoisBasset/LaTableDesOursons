<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
		$menu = new Menu();
		$menu->setNom("Menu de l'Ours");
		$menu->setPrix(22.50);
		$menu->addCategory($this->getReference('entrees_ours'));
		$menu->addCategory($this->getReference('plats_ours'));
		$menu->addCategory($this->getReference('desserts_ours'));

		$manager->persist($menu);

		$menu = new Menu();
		$menu->setNom("Menu de l'Ourse");
		$menu->setPrix(20.80);
		$menu->addCategory($this->getReference('entrees_ourse'));
		$menu->addCategory($this->getReference('plats_ourse'));
		$menu->addCategory($this->getReference('desserts_ourse'));
		$manager->persist($menu);

        $manager->flush();
    }

	public function getDependencies()
	{
		return [
			PlatFixtures::class
		];
	}
}
