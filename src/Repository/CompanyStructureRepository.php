<?php

namespace App\Repository;

use App\Entity\CompanyStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyStructure>
 *
 * @method CompanyStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyStructure[]    findAll()
 * @method CompanyStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyStructure::class);
    }

//    /**
//     * @return CompanyStructure[] Returns an array of CompanyStructure objects
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

//    public function findOneBySomeField($value): ?CompanyStructure
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
