<?php

namespace App\Repository;

use App\Entity\VideoNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoNews>
 *
 * @method VideoNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoNews[]    findAll()
 * @method VideoNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoNews::class);
    }

//    /**
//     * @return VideoNews[] Returns an array of VideoNews objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoNews
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
