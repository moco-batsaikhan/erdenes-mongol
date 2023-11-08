<?php

namespace App\Repository;

use App\Entity\WebConfigTs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebConfigTs>
 *
 * @method WebConfigTs|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebConfigTs|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebConfigTs[]    findAll()
 * @method WebConfigTs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebConfigTsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebConfigTs::class);
    }

//    /**
//     * @return WebConfigTs[] Returns an array of WebConfigTs objects
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

//    public function findOneBySomeField($value): ?WebConfigTs
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
