<?php

namespace App\Parser\Repository;

use App\Parser\Entity\NewsParserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsParserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsParserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsParserEntity[]    findAll()
 * @method NewsParserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsParserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsParserEntity::class);
    }

    // /**
    //  * @return NewsParser[] Returns an array of NewsParser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsParser
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
