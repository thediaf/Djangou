<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $language = new Language();
        $language->setName('Francais');
        $manager->persist($language);

        $language1 = new Language();
        $language1->setName('Anglais');
        $manager->persist($language1);

        $language2 = new Language();
        $language2->setName('Wolof');
        $manager->persist($language2);

        $language3 = new Language();
        $language3->setName('Pulaar');
        $manager->persist($language3);

        $manager->flush();
    }
}
