<?php

namespace App\Controller\Api;

use App\Entity\Layout;
use App\Entity\MainCategory;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class MenuController extends AbstractController
{
    #[Route('/menu/{type}', name: 'menu_index', methods: ['get'])]
    public function getAction(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, $type): Response
    {
        $type = strtoupper($type);

        $lang = $request->get('lang') ? $request->get('lang') : 'mn';
        // $data = $entityManager->getRepository(MainCategory::class)
        //     ->createQueryBuilder('p')
        //     ->leftjoin('App\Entity\NewsType', 'nt', \Doctrine\ORM\Query\Expr\Join::WITH, 'nt.id = p.newsType')
        //     ->leftjoin('App\Entity\News', 'n', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id = p.newsId')
        //     ->select('p,n,nt')
        //     ->where('p.type = :HEADER')
        //     ->andWhere('p.active = 1')
        //     ->setParameter('HEADER', $type)
        //     ->orderBy('p.priority', 'ASC')
        //     ->getQuery()
        //     ->getScalarResult();

        $queryBuilder = $entityManager->getRepository(MainCategory::class)
            ->createQueryBuilder('p')
            ->leftjoin('App\Entity\NewsType', 'nt', \Doctrine\ORM\Query\Expr\Join::WITH, 'nt.id = p.newsType')
            ->leftjoin('App\Entity\News', 'n', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id = p.newsId')
            ->select('p,n,nt')
            ->where('p.active = 1')
            ->orderBy('p.priority', 'ASC');

        if ($type === 'HEADER') {
            $queryBuilder->andWhere('p.type IN (:TYPES)')
                ->setParameter('TYPES', ['HEADER', 'ALL']);
        } elseif ($type === 'FOOTER') {
            $queryBuilder->andWhere('p.type IN (:TYPES)')
                ->setParameter('TYPES', ['FOOTER', 'ALL']);
        }

        $data = $queryBuilder->getQuery()->getScalarResult();

        $menuDto = [];
        foreach ($data as $key => $value) {
            $menuDto[] = [
                'id' => $value['p_id'],
                'name' => $value['p_' . $lang . 'Name'],
                'type' => $value['p_type'],
                'active' => $value['p_active'],
                'link' => $value['p_redirectLink'],
                'newsId' => $value['n_id'],
                'newsTypeId' => $value['nt_id'],
                'clickType' => $value['p_clickType']
            ];
        }

        $section = $serializer->serialize($menuDto, 'json');


        $response = [
            'data' => json_decode($section)
        ];

        return new JsonResponse($response);
    }

    #[Route('/menu/{type}/{mainId}', requirements: ['mainId' => '\d+'], name: 'menu_sub', methods: ['get'])]
    public function getSubAction(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, $type, $mainId): Response
    {
        $lang = $request->get('lang') ? $request->get('lang') : 'mn';
        $data = $entityManager->getRepository(SubCategory::class)
            ->createQueryBuilder('p')
            ->select('p,n,nt')
            ->leftjoin('App\Entity\MainCategory', 'mc', \Doctrine\ORM\Query\Expr\Join::WITH, 'mc.id = p.mainCategoryId')
            ->leftjoin('App\Entity\NewsType', 'nt', \Doctrine\ORM\Query\Expr\Join::WITH, 'nt.id = p.newsTypeId')
            ->leftjoin('App\Entity\News', 'n', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id = p.newsId')
            ->where('mc.id = :MC_ID')
            ->andWhere('mc.type = :MC_TYPE')
            ->andWhere('p.active = 1')
            ->setParameter('MC_ID', $mainId)
            ->setParameter('MC_TYPE', $type)
            ->orderBy('p.priority', 'ASC')
            ->getQuery()
            ->getScalarResult();


        $subMenuDto = [];
        foreach ($data as $key => $value) {
            $subMenuDto[] = [
                'id' => $value['p_id'],
                'name' => $value['p_' . $lang . 'Name'],
                'active' => $value['p_active'],
                'link' => $value['p_redirectLink'],
                'newsId' => $value['n_id'],
                'newsTypeId' => $value['nt_id'],
                'clickType' => $value['p_clickType']
            ];
        }

        $section = $serializer->serialize($subMenuDto, 'json');


        $response = [
            'data' => json_decode($section)
        ];

        return new JsonResponse($response);
    }
}
