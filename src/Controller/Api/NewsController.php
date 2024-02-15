<?php

namespace App\Controller\Api;

use App\Entity\News;
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
    #[Route('/news/{type}/{page}', name: 'news_index', requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['get'])]
    public function index(ManagerRegistry $doctrine, SerializerInterface $serializer, $type, $page)
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


        switch ($type) {
            case 'video':
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

            case 'statistics':
                $count->andWhere('nt.id = 4');
                $data->andWhere('nt.id = 4');
                break;
            case 'project':
                $count->andWhere('nt.id = 5');
                $data->andWhere('nt.id = 5');
                break;
            case 'published':
                $count->andWhere('nt.id = 3');
                $data->andWhere('nt.id = 3');
                break;

            default:
                return new JsonResponse(['code' => 404, 'message' => 'Алдаа! Буруу утга оруулсан байна.', 'allowedTypes' => ['video', 'statistics', 'project', 'published']]);

        }

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

        $data = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p')
            ->where('p.active = 1')
            ->andWhere('p.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();

        $news = $serializer->serialize($data, 'json');


        $response = [
            'data' => json_decode($news)
        ];

        return new JsonResponse($response);
    }


}