<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Translate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class TranslationFixtures extends Fixture implements DependentFixtureInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;     
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $language = new Language();
        
        $word = new Translate();
        $word->setWord('bonjour');
        $word->setClasse('interjection');
        $word->setLanguage($this->em->getRepository(Language::class)->findOneByName('Francais')); 
        $manager->persist($word);
        $word1 = new Translate();

        $word1->setWord('good morning');        
        $word1->setLanguage($this->em->getRepository(Language::class)->findOneByName('Anglais'));
        $word1->addWords($word);
        $word1->setClasse('interjection');
        $manager->persist($word1);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [LanguageFixtures::class];
    }
}
