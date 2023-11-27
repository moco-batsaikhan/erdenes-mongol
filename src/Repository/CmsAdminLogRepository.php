<?php

namespace App\Repository;

use App\Entity\CmsAdminLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    public function getAllData($page, $pageSize)
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery();

        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $pageSize);
        $data = $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize)
            ->getArrayResult();

        return [
            'data' => $data,
            'totalItems' => $totalItems,
            'pageCount' => $pagesCount
        ];
    }
}
