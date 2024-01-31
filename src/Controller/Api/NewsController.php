<?php

namespace App\Controller\Api;

use App\Entity\News;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class NewsController extends AbstractController
{
    #[Route('/news/{page}', name: 'news_index', requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['get'])]
    public function index(ManagerRegistry $doctrine, SerializerInterface $serializer, $page)
    {
        $pagesize = 20;
        $qb = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p');

        $cloneQb = clone $qb;
        $count = $cloneQb->select('count(p.id)')->where('p.active = 1')->getQuery()->getSingleScalarResult();
        $news = $qb->setFirstResult(($page - 1) * $pagesize)
            ->setMaxResults($pagesize)
            ->where('p.active = 1')
            ->getQuery()
            ->getArrayResult();

        $reports = $serializer->serialize($news, 'json');


        $response = [
            'count' => $count,
            'pagesize' => $pagesize,
            'data' => json_decode($reports)
        ];




        return new JsonResponse($response);
    }

}