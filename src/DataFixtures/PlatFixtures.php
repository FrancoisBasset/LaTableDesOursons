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
			["Foie gras poêlé", 10, "foie_gras_poele.jpg"],
			["Viande des Grisons", 12, "viande_des_grisons.jpg"],
			["Salade Savoyarde", 14, "salade_savoyarde.jpg"],
			["Salade de chèvre chaud", 13, 'salade_de_chevre_chaud.jpg'],
			["Assiette de saumon fumé", 12, 'assiette_de_saumon_fume.jpg'],
			["Soupe d'artichaut", 17, 'soupe_d_artichaut.jpg']
		];
		$plats = [
			["Raclette traditionnelle, pommes de terre, fromage et charcuterie", 14, 'raclette.jpg'],
			["Fondue Savoyarde", 15, 'fondue_savoyarde.jpg'],
			["Tartiflette", 11, 'tartiflette.jpg'],			
			["Pâtes carbonara", 15, 'pates_carbonara.jpg'],
			["Omelette aux champignons", 10, 'omelette_aux_champignons.jpg']
		];
		$desserts = [
			["Crêpe à la crème de marron", 6, 'crepe_creme_de_marron.jpg'],
			["Gaufre liègeoise", 4, 'gaufre_liegeoise.jpg'],
			["Tarte aux myrtilles", 9, 'tarte_aux_myrtilles.jpg'],
			["Glace à la myrtille", 12, 'glace_a_la_myrtille.jpg'],
			["Nougat glacé", 11, 'nougat_glace.jpg'],
			["Crème brulée", 7, 'creme_brulee.jpg']
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
				$plat->setImage($p[2]);
				$plat->setCategorie($this->getReference($categorie));
				$manager->persist($plat);
			}
		}

        $manager->flush();
    }
}
