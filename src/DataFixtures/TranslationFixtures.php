<?php

namespace App\DataFixtures;

use App\Entity\Language;
use App\Entity\Translate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TranslationFixtures extends Fixture //implements DependentFixtureInterface
{
    private $em;
    private $parameter;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameter)
    {
        $this->parameter = $parameter;
        $this->em = $em;     
    }

    public function load(ObjectManager $manager)
    {
        $dir = $this->parameter->get('kernel.project_dir') . '/var/app/';
        
        $pl = $dir . 'wolof-fr.txt';
        $lines = explode("\n", file_get_contents($pl));
        
        foreach ($lines as $line) {
            $words = explode(":", $line);

            if(count($words) !== 2)
                continue;
            
            $translatedWord = trim(substr($words[1], 0, strpos($words[1], ".")));
            
            $word = (new Translate())
                ->setWord(trim($words[0]))
                ->setLanguage($this->em->getRepository(Language::class)->findOneByName('Pulaar'))
            ;

            $translated = (new Translate())
                ->setWord($translatedWord)
                ->setLanguage($this->em->getRepository(Language::class)->findOneByName('Francais'))
                ->addTranslate($word)
            ;

            $manager->persist($translated);
            $manager->persist($word);
        }

        $pl = $dir . 'pulaar-fr.txt';
        $lines = explode("\n", file_get_contents($pl));
        
        foreach ($lines as $line) {
            $words = explode(":", $line);

            if(count($words) !== 2)
                continue;
            
            $translatedWord = trim(substr($words[1], 0, strpos($words[1], ".")));
            
            $word = (new Translate())
                ->setWord(trim($words[0]))
                ->setLanguage($this->em->getRepository(Language::class)->findOneByName('Pulaar'))
            ;

            $translated = (new Translate())
                ->setWord($translatedWord)
                ->setLanguage($this->em->getRepository(Language::class)->findOneByName('Francais'))
                ->addTranslate($word)
            ;

            $manager->persist($translated);
            $manager->persist($word);
        }
        $manager->flush();
    }


    private  function getInterjection(string $str): ?string
    {   
        switch(trim($str)) {
            case 'n':
                return 'Nom';
            case 'adj':
                return 'Adjectif';
            case 'v':
                return 'Verbe';
            case 'adv':
                return 'Adverbe';
            case 'conj':
                return 'Conjonction';
            case 'rel': 
                return 'Relative';
            case 'interrog':
                return 'Interrogative';
            case 'pr':
                return 'Pronom';
            case 'pron':
                return 'Pronom';
            default:
                return null;
        }
    }

    public function getDependencies()
    {
        return [LanguageFixtures::class];
    }
}
