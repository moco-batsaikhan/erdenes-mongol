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
    public function index(Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer, $typeId, $page)
    {
        $pagesize = 20;


        $lang = $request->get('lang') ? $request->get('lang') : 'mn';


        $qb = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p');
        $cloneQb = clone $qb;
        $count = $cloneQb->select('count(p.id)')->where('p.active = 1')
            ->leftJoin('p.newsType', 'nt');


        $data = $qb
            ->where('p.active = 1')
            ->leftJoin('p.newsType', 'nt');



        if ($typeId == "7") {
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
            ->getScalarResult();

        $newsDto = [];
        foreach ($data as $key => $value) {
            $newsDto[] = [
                'id' => $value['p_id'],
                'title' => $value['p_' . $lang . 'Title'],
                'headLine' => $value['p_' . $lang . 'Headline'],
                'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $value['p_imageUrl'],
                'redirectType' => $value['p_redirectType'],
                'active' => $value['p_active'],
                'special' => $value['p_isSpecial'],
                'createdDate' => $value['p_createdAt']
            ];
        }

        $news = $serializer->serialize($newsDto, 'json');

        $response = [
            'count' => $count,
            'pagesize' => $pagesize,
            'data' => json_decode($news)
        ];

        return new JsonResponse($response);
    }


    #[Route('/newsDetail/{id}', name: 'news_detail', requirements: ['id' => '\d+'], methods: ['get'])]
    public function detail(Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer, $id)
    {

        $lang = $request->get('lang') ? $request->get('lang') : 'mn';
        $isSpecial = $request->get('isSpecial');

        $qb = $doctrine
            ->getRepository(News::class)
            ->createQueryBuilder('p')
            ->where('p.active = 1')
            ->andWhere('p.id = :id');
        if ($isSpecial) {
            $qb->andWhere('p.isSpecial = :special')
                ->setParameter('special', $isSpecial);
        }
        $news = $qb->setParameter('id', $id)
            ->getQuery()
            ->getScalarResult();

        if (!isset($news[0])) {
            return new JsonResponse(['code' => '404', 'message' => 'Not found news by id ' . $id]);
        }
        $news = $news[0];


        $newsDto = [
            'id' => $news['p_id'],
            'title' => $news['p_' . $lang . 'Title'],
            'headLine' => $news['p_' . $lang . 'Headline'],
            'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $news['p_imageUrl'],
            'redirectType' => $news['p_redirectType'],
            'active' => $news['p_active'],
            'special' => $news['p_isSpecial'],
            'createdDate' => $news['p_createdAt']
        ];
        $contents = $doctrine
            ->getRepository(Content::class)
            ->createQueryBuilder('p')
            ->where('p.active = 1')
            ->andWhere('p.News = :id')
            ->setParameter('id', $newsDto['id'])
            ->orderBy('p.priority', 'ASC')
            ->getQuery()
            ->getScalarResult();
        $newContentsDto = [];

        foreach ($contents as $key => $value) {
            $newContentsDto[] = [
                'id' => $value['p_id'],
                'name' => $value['p_name'],
                'type' => $value['p_type'],
                'body' => $value['p_body'],
                'active' => $value['p_active'],
                'file' =>  $value['p_file'],
                'graphType' => $value['p_graphType'],
                'pdfFileUrl' => $this->getParameter('base_url') . 'uploads/pdf/' . $value['p_pdfFileName']

            ];
        }



        $newsDto['content'] = $newContentsDto;



        $news = $serializer->serialize($newsDto, 'json');



        $response = [
            'news' => json_decode($news)
        ];

        return new JsonResponse($response);
    }
}
