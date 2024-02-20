<?php

namespace App\Controller\Api;

use App\Entity\News;
use App\Entity\Content;
use App\Entity\VideoNews;
use Exception;
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
    #[Route('/news/{typeId}/{page}', name: 'news_index', requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['get'])]
    public function index(ManagerRegistry $doctrine, SerializerInterface $serializer, $typeId, $page)
    {
        $pagesize = 20;


        $qb = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p');
        $cloneQb = clone $qb;
        $count = $cloneQb->select('count(p.id)')->where('p.active = 1')
            ->leftJoin('p.newsType', 'nt');


        $data = $qb
            ->where('p.active = 1')
            ->leftJoin('p.newsType', 'nt');



        if ($typeId == "videoMedee") {
            $videoBuilder = $doctrine->getRepository(VideoNews::class)->createQueryBuilder('p');
            $cloneQuery = clone $videoBuilder;
            $countVideo = $cloneQuery->select('count(p.id)')->where('p.active = 1')->getQuery()->getSingleScalarResult();
            $videoNews = $videoBuilder->where('p.active = 1')
                ->setFirstResult(($page - 1) * $pagesize)
                ->setMaxResults($pagesize)
                ->getQuery()
                ->getArrayResult();

            $news = $serializer->serialize($videoNews, 'json');


            $response = [
                'count' => $countVideo,
                'pagesize' => $pagesize,
                'data' => json_decode($news)
            ];

            return new JsonResponse($response);
        }




        $count->andWhere('nt.id = ' . $typeId);
        $data->andWhere('nt.id = ' . $typeId);


        $count = $count
            ->getQuery()
            ->getSingleScalarResult();
        $data = $data
            ->setFirstResult(($page - 1) * $pagesize)
            ->setMaxResults($pagesize)
            ->getQuery()
            ->getArrayResult();

        $news = $serializer->serialize($data, 'json');


        $response = [
            'count' => $count,
            'pagesize' => $pagesize,
            'data' => json_decode($news)
        ];

        return new JsonResponse($response);
    }


    #[Route('/newsDetail/{id}', name: 'news_detail', requirements: ['id' => '\d+'], methods: ['get'])]
    public function detail(ManagerRegistry $doctrine, SerializerInterface $serializer, $id)
    {

        $news = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p')
            ->where('p.active = 1')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getScalarResult()[0];




        $content = $doctrine
            ->getRepository(Content::class)
            ->createQueryBuilder('p')
            ->where('p.active = 1')
            ->andWhere('p.News = :id')
            ->setParameter('id', $news['p_id'])
            ->getQuery()
            ->getScalarResult()[0];

        $news['content'] = $content;

        $news = $serializer->serialize($news, 'json');



        $response = [
            'news' => json_decode($news)
        ];

        return new JsonResponse($response);
    }


}