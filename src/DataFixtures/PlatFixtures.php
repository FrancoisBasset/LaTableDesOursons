<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
		$fondue = ['Fondue Savoyarde', 15, 'fondue_savoyarde'];

		$boissons_alcoolises = [
			['Heineken', 3, 'heineken'],
			['Martini', 4, 'martini']
		];
		$boissons_non_alcoolises = [
			['Limonade', 2, 'limonade'],
			['Jus d\'orange', 5, 'jus_d_orange']
		];
		
		$entrees_ours = [
			['Foie gras poêlé', 10, 'foie_gras_poele'],
			['Viande des Grisons', 12, 'viande_des_grisons'],
			['Salade Savoyarde', 14, 'salade_savoyarde']
		];
		$plats_ours = [
			['Raclette traditionnelle, pommes de terre, fromage et charcuterie', 14, 'raclette'],
			['Tartiflette', 11, 'tartiflette']
		];
		$desserts_ours = [
			['Crêpe à la crème de marron', 6, 'crepe_creme_de_marron'],
			['Gaufre liègeoise', 4, 'gaufre_liegeoise'],
			['Tarte aux myrtilles', 9, 'tarte_aux_myrtilles']
		];

		$entrees_ourse = [
			['Salade de chèvre chaud', 13, 'salade_de_chevre_chaud'],
			['Assiette de saumon fumé', 12, 'assiette_de_saumon_fume'],
			['Soupe d\'artichaut', 17, 'soupe_d_artichaut']
		];
		$plats_ourse = [
			['Pâtes carbonara', 15, 'pates_carbonara'],
			['Omelette aux champignons', 10, 'omelette_aux_champignons']
		];
		$desserts_ourse = [
			['Glace à la myrtille', 12, 'glace_a_la_myrtille'],
			['Nougat glacé', 11, 'nougat_glace'],
			['Crème brulée', 7, 'creme_brulee']
		];

		$ensemble = [
			'entrees_ours' => $entrees_ours,
			'entrees_ourse' => $entrees_ourse,
			'plats_ours' => $plats_ours,
			'plats_ourse' => $plats_ourse,
			'desserts_ours' => $desserts_ours,
			'desserts_ourse' => $desserts_ourse,
			'carte_boissons_alcoolises' => $boissons_alcoolises,
			'carte_boissons_non_alcoolises' => $boissons_non_alcoolises
		];

		foreach ($ensemble as $nomCategorie => $plats) {
			foreach ($plats as $p) {
				$plat = new Plat();
				$plat->setNom($p[0]);
				$plat->setPrix($p[1]);
				$plat->setImage($p[2].'.jpg');
				$plat->addCategoriePlat($this->getReference($nomCategorie));
				if (str_contains($nomCategorie, 'entrees')) {
					$plat->addCategoriePlat($this->getReference('carte_entrees'));
				} else if (str_contains($nomCategorie, 'plats')) {
					$plat->addCategoriePlat($this->getReference('carte_plats'));
				} else if (str_contains($nomCategorie, 'desserts')) {
					$plat->addCategoriePlat($this->getReference('carte_desserts'));
				}
				$manager->persist($plat);
			}
		}

		$plat = new Plat();
		$plat->setNom($fondue[0]);
		$plat->setPrix($fondue[1]);
		$plat->setImage($fondue[2].'.jpg');
		$plat->addCategoriePlat($this->getReference('plats_ours'));
		$plat->addCategoriePlat($this->getReference('plats_ourse'));
		$manager->persist($plat);

        $manager->flush();
    }
}