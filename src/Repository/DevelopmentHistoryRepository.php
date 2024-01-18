<?php

namespace App\Repository;

use App\Entity\DevelopmentHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DevelopmentHistory>
 *
 * @method DevelopmentHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevelopmentHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevelopmentHistory[]    findAll()
 * @method DevelopmentHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevelopmentHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevelopmentHistory::class);
    }

//    /**
//     * @return DevelopmentHistory[] Returns an array of DevelopmentHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DevelopmentHistory
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
