<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$entrees = [
			["Foie gras poêlé", 10, "foie_gras_poele"],
			["Viande des Grisons", 12, "viande_des_grisons"],
			["Salade Savoyarde", 14, "salade_savoyarde"],
			["Salade de chèvre chaud", 13, 'salade_de_chevre_chaud'],
			["Assiette de saumon fumé", 12, 'assiette_de_saumon_fume'],
			["Soupe d'artichaut", 17, 'soupe_d_artichaut']
		];
		$plats = [
			["Raclette traditionnelle, pommes de terre, fromage et charcuterie", 14, 'raclette'],
			["Fondue Savoyarde", 15, 'fondue_savoyarde'],
			["Tartiflette", 11, 'tartiflette'],			
			["Pâtes carbonara", 15, 'pates_carbonara'],
			["Omelette aux champignons", 10, 'omelette_aux_champignons']
		];
		$desserts = [
			["Crêpe à la crème de marron", 6, 'crepe_creme_de_marron'],
			["Gaufre liègeoise", 4, 'gaufre_liegeoise'],
			["Tarte aux myrtilles", 9, 'tarte_aux_myrtilles'],
			["Glace à la myrtille", 12, 'glace_a_la_myrtille'],
			["Nougat glacé", 11, 'nougat_glace'],
			["Crème brulée", 7, 'creme_brulee']
		];

		$ensemble = [
			'entrees' => $entrees,
			'plats' => $plats,
			'desserts' => $desserts
		];

		foreach ($ensemble as $categorie => $plats) {
			foreach ($plats as $p) {
				$plat = new Plat();
				$plat->setNom($p[0]);
				$plat->setPrix($p[1]);
				$plat->setImage($p[2].'.jpg');
				$this->addReference($p[2], $plat);
				$plat->setCategorie($this->getReference($categorie));
				$manager->persist($plat);
			}
		}

        $manager->flush();
    }
}
