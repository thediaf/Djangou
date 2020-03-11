<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Translate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;


/**
 * @method Translate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translate[]    findAll()
 * @method Translate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translate::class);
    }

    public function findWord(Search $search)
    {
        $query = $this->findWordQuery();
        
        if ($search->getWord())
        {
            $query = $query->leftJoin('t.word', 'w')
                        ->addSelect('w')
                        ->Where('w.language = :lang')
                        ->setParameter('lang', $search->getWordLanguage())
                        ->andWhere('w.word', $search->getWord())
                        ->andWhere('t.language = :wordLang')
                        ->setParameter('wordLang', $search->getTranslateLanguage());
        }   
        return $query->getQuery()->getResult();
    }


    public function findWordQuery(): ORMQueryBuilder
    {
        return $this->createQueryBuilder('t');
    }
}
