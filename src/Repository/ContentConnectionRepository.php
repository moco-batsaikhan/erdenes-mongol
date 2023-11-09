<?php

namespace App\Repository;

use App\Entity\ContentConnection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContentConnection>
 *
 * @method ContentConnection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentConnection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentConnection[]    findAll()
 * @method ContentConnection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentConnectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentConnection::class);
    }

//    /**
//     * @return ContentConnection[] Returns an array of ContentConnection objects
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

//    public function findOneBySomeField($value): ?ContentConnection
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
