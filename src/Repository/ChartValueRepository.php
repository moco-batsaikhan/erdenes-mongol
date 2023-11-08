<?php

namespace App\Repository;

use App\Entity\ChartValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChartValue>
 *
 * @method ChartValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChartValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChartValue[]    findAll()
 * @method ChartValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChartValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChartValue::class);
    }

//    /**
//     * @return ChartValue[] Returns an array of ChartValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChartValue
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
