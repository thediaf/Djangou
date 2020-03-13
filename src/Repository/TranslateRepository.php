<?php

namespace App\Repository;

use App\Entity\Language;
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

    public function getTranslationOf(Search $search)//: ?Translate
    {
        $queryBuilder = $this->findWordQuery();

        $source = $this->getSourceTranslate($search);

        return $queryBuilder
            ->leftJoin('t.translates', 'trans')
                ->addSelect('trans')
            ->leftJoin('t.words', 'w')
                ->addSelect('w')
            ->where('t.language = :lang')
            ->andWhere('trans = :word')
            ->orWhere('w = :word')
            ->setParameter('lang', $search->getTranslateLanguage())
            ->setParameter('word', $source)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function getSourceTranslate(Search $search): ?Translate
    {
        return $this->findWordQuery()
            ->leftJoin('t.language', 'lang')
                ->addSelect('lang')
            ->where('lang.id = :lang')
            ->andWhere('t.word = :word')
            ->setParameter('lang', $search->getWordLanguage())
            ->setParameter('word', $search->getWord())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * TODO: Implements pagination
     */
    public function paginateByLanguage(Language $language, int $page)
    {
        return $this->createQueryBuilder('t')
            ->where('t.language = :lang')
            ->setParameter('lang', $language)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findWordQuery(): ORMQueryBuilder
    {
        return $this->createQueryBuilder('t');
    }
}
