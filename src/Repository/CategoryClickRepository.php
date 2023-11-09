<?php

namespace App\Repository;

use App\Entity\CategoryClick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryClick>
 *
 * @method CategoryClick|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryClick|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryClick[]    findAll()
 * @method CategoryClick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryClickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryClick::class);
    }

//    /**
//     * @return CategoryClick[] Returns an array of CategoryClick objects
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

//    public function findOneBySomeField($value): ?CategoryClick
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
