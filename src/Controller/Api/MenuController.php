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
    public function getAction(EntityManagerInterface $entityManager, SerializerInterface $serializer,$type): Response
    {
        $data = $entityManager->getRepository(MainCategory::class)
            ->createQueryBuilder('p')
            ->where('p.type = :HEADER')
            ->andWhere('p.active = 1')
            ->setParameter('HEADER',$type)
            ->orderBy('p.priority', 'ASC')
            ->getQuery()
            ->getArrayResult();

        $section = $serializer->serialize($data, 'json');


        $response = [
            'data' => json_decode($section)
        ];

        return new JsonResponse($response);
    }

    #[Route('/menu/{type}/{mainId}',requirements: ['mainId' => '\d+'], name: 'menu_sub', methods: ['get'])]
    public function getSubAction(EntityManagerInterface $entityManager, SerializerInterface $serializer,$type,$mainId): Response
    {
        $data = $entityManager->getRepository(SubCategory::class)
            ->createQueryBuilder('p')
            ->leftjoin('App\Entity\MainCategory','mc', \Doctrine\ORM\Query\Expr\Join::WITH, 'mc.id = p.mainCategoryId')
            ->where('mc.id = :MC_ID')
            ->andWhere('mc.type = :MC_TYPE')
            ->andWhere('p.active = 1')
            ->setParameter('MC_ID',$mainId)
            ->setParameter('MC_TYPE',$type)
            ->orderBy('p.priority', 'ASC')
            ->getQuery()
            ->getArrayResult();

        $section = $serializer->serialize($data, 'json');


        $response = [
            'data' => json_decode($section)
        ];

        return new JsonResponse($response);
    }
}
