<?php

namespace App\Repository;

use App\Entity\WebConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebConfig>
 *
 * @method WebConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebConfig[]    findAll()
 * @method WebConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebConfig::class);
    }

    //    /**
    //     * @return WebConfig[] Returns an array of WebConfigTs objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?WebConfig
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
