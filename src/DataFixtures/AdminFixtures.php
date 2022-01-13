<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
		$admin->setUsername('admin');
		$admin->setPassword('$2y$13$dga2lvAMWxRmnnnTIO75QutWzSjo3F16sdzyxBpdMpBIzM0dEwStO');
		$admin->setRoles(['ROLE_ADMIN']);
		$manager->persist($admin);

        $manager->flush();
    }
}
