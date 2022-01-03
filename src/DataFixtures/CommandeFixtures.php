<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\CommandeMenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
		$commandeMenu = new CommandeMenu();
		$commandeMenu->setMenu($this->getReference('menu_ours'));
		$commandeMenu->addPlat($this->getReference('foie_gras_poele'));
		$commandeMenu->addPlat($this->getReference('tartiflette'));
		$commandeMenu->addPlat($this->getReference('tarte_aux_myrtilles'));

		$commande = new Commande();
		$commande->setCode('ABCDEF');
		$commande->setPrenom('François');
		$commande->setNom('Basset');
		$commande->setPrix(25.62);
		$commande->setEtat('commandé');
		
		$commande->addMenu($commandeMenu);
		$commande->addPlat($this->getReference('limonade'));

		$manager->persist($commandeMenu);
		$manager->persist($commande);

        $manager->flush();
    }

	public function getDependencies()
	{
		return [
			PlatFixtures::class,
			MenuFixtures::class
		];
	}
}
