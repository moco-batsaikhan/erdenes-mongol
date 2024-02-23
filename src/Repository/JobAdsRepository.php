<?php

namespace App\Repository;

use App\Entity\JobAds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobAds>
 *
 * @method JobAds|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobAds|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobAds[]    findAll()
 * @method JobAds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobAdsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobAds::class);
    }

//    /**
//     * @return JobAds[] Returns an array of JobAds objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobAds
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
