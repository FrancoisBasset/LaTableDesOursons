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
		$commande = new Commande();
		$commande->setCode('ABCDEF');
		$commande->setPrenom('François');
		$commande->setNom('Basset');
		$commande->setPrix(25.62);
		$commande->setEtat('commandé');
		$commande->setPlats(['nom' => 'Limonade', 'prix' => 2]);

		$commandeMenu = new CommandeMenu();
		$commandeMenu->setMenu(['nom' => 'Menu de l\'ourse', 'prix' => 20.80]);
		$commandeMenu->setPlats([
			['nom' => 'Salade de chèvre chaud', 'prix' => 13],
			['nom' => 'Pâtes carbonara', 'prix' => 15],
			['nom' => 'Glace à la myrtille', 'prix' => 12]
		]);
		$commande->addCommandeMenu($commandeMenu);
		
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
