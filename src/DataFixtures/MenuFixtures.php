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

		$menu->addPlat($this->getReference('foie_gras_poele'));
		$menu->addPlat($this->getReference('viande_des_grisons'));
		$menu->addPlat($this->getReference('salade_savoyarde'));
		$menu->addPlat($this->getReference('raclette'));
		$menu->addPlat($this->getReference('fondue_savoyarde'));
		$menu->addPlat($this->getReference('tartiflette'));
		$menu->addPlat($this->getReference('crepe_creme_de_marron'));
		$menu->addPlat($this->getReference('gaufre_liegeoise'));
		$menu->addPlat($this->getReference('tarte_aux_myrtilles'));

		$manager->persist($menu);

		$menu = new Menu();
		$menu->setNom("Menu de l'Ourse");
		$menu->setPrix(20.80);
		$menu->addPlat($this->getReference('salade_de_chevre_chaud'));
		$menu->addPlat($this->getReference('assiette_de_saumon_fume'));
		$menu->addPlat($this->getReference('soupe_d_artichaut'));
		$menu->addPlat($this->getReference('pates_carbonara'));
		$menu->addPlat($this->getReference('fondue_savoyarde'));
		$menu->addPlat($this->getReference('omelette_aux_champignons'));
		$menu->addPlat($this->getReference('glace_a_la_myrtille'));
		$menu->addPlat($this->getReference('nougat_glace'));
		$menu->addPlat($this->getReference('creme_brulee'));
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
