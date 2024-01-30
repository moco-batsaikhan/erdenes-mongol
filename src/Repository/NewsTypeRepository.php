<?php

namespace App\Repository;

use App\Entity\NewsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsType>
 *
 * @method NewsType|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsType|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsType[]    findAll()
 * @method NewsType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsType::class);
    }

//    /**
//     * @return NewsType[] Returns an array of NewsType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewsType
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
