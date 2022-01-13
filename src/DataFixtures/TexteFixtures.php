<?php

namespace App\DataFixtures;

use App\Entity\Texte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TexteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $texte1 = new Texte();
		$texte1->setPosition(0);
		$texte1->setTexteFr('<ourson>¤Le restaurant La Table des Oursons vous accueille tous les jours de 12h00 à 15h00 et de 18h00 à 23h00.¤<ourson_mirror>');
		$texte1->setTexteEn('<ourson>¤The restaurant La Table des Oursons welcomes you every day from 12h00 to 15h00 and from 18h00 to 23h00.¤<ourson_mirror>');
		$manager->persist($texte1);

		$texte2 = new Texte();
		$texte2->setPosition(1);
		$texte2->setTexteFr('<ourson>¤Avant, pendant ou après votre session de ski, venez vous restaurez avec nos spécialités locales. Nous vous proposons des menus raclettes, fondues, tartiflettes et pierrades. Les pommes de terre, fromages et charcuteries pour la raclette sont à volontés. En guise de fromages et de desserts, le restaurant vous propose un plateau de fromages et de desserts. Nous servons également de la cuisine française traditionnelle venant de toutes régions.¤<ourson_mirror>');
		$texte2->setTexteEn('<ourson>¤Before, during or after your ski session, come and enjoy our local specialties. We propose you menus raclettes, fondues, tartiflettes and pierrades. Potatoes, cheese and cold cuts for the raclette are at will. The restaurant offers a cheese and dessert platter. We also serve traditional French cuisine from all regions.¤<ourson_mirror>');
		$manager->persist($texte2);

		$texte3 = new Texte();
		$texte3->setPosition(2);
		$texte3->setTexteFr('<ourson>¤Le restaurant propose également des activités comme le réveillon de Noël avec l\'arrivée du Père Noël le soir du 24 décembre et le réveillon du Nouvel An. Le restaurant possède une salle de jeux avec un billard et un baby-foot. Le restaurant organise des anniversaires, baptèmes, mariages, séminaires ou tout autres évènements.¤<ourson_mirror>');
		$texte3->setTexteEn('<ourson>¤The restaurant also offers activities such as Christmas Eve with the arrival of Santa Claus on December 24 and New Year\'s Eve. The restaurant has a games room with a pool table and table soccer. The restaurant organizes birthdays, christenings, weddings, seminars and other events.¤<ourson_mirror>');
		$manager->persist($texte3);

		$texte4 = new Texte();
		$texte4->setPosition(3);
		$texte4->setTexteFr('<ourson>¤Nous acceptons le paiement en espèces, chèques, cartes bancaires et tickets restaurants.¤<ourson_mirror>');
		$texte4->setTexteEn('<ourson>¤We accept payment in cash, checks, credit cards and luncheon vouchers.¤<ourson_mirror>');
		$manager->persist($texte4);

        $manager->flush();
    }
}
