<?php

namespace App\Repository;

use App\Entity\MapType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapType>
 *
 * @method MapType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapType[]    findAll()
 * @method MapType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapType::class);
    }

    public function findAllActives() {
        $qb = $this->createQueryBuilder('p')->where('p.active = true');
        return $qb->distinct();
    }

//    /**
//     * @return MapType[] Returns an array of MapType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MapType
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
