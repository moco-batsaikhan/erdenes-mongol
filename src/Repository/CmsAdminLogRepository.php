<?php

namespace App\Repository;

use App\Entity\CmsAdminLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CmsAdminLog>
 *
 * @method CmsAdminLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CmsAdminLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CmsAdminLog[]    findAll()
 * @method CmsAdminLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CmsAdminLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CmsAdminLog::class);
    }

//    /**
//     * @return CmsAdminLog[] Returns an array of CmsAdminLog objects
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

//    public function findOneBySomeField($value): ?CmsAdminLog
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
