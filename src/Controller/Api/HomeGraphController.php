<?php

namespace App\Controller\Api;

use App\Entity\Content;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api', name: 'api_')]
class HomeGraphController extends AbstractController
{

    #[Route('/home/graph', name: 'home_graph_api',  methods: ['GET'])]
    public function getEmployees(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $lang = $request->query->get('lang') ?: 'mn';

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e')
            ->from(Content::class, 'e')
            ->where('e.active = 1')
            ->andWhere('e.type = :type')
            ->setParameter('type', 'HOME_JSON')
            ->orderBy('e.createdAt', 'DESC')
            ->setMaxResults(1);

        $query = $qb->getQuery();
        $data = $query->getOneOrNullResult();

        if (!$data) {
            return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        }

        $description = '';
        switch ($lang) {
            case 'mn':
                $description = $data->getMnDescription();
                break;
            case 'en':
                $description = $data->getEnDescription();
                break;
            case 'cn':
                $description = $data->getCnDescription();
                break;
            default:
                $description = $data->getMnDescription();
                break;
        }

        $dataDto = [
            'id' => $data->getId(),
            'description' => $description,
            'graphType' => $data->getGraphType(),
            'json' => $data->getFile(),
            'createdDate' => $data->getCreatedAt()->format('Y-m-d H:i:s')
        ];

        $item = $serializer->serialize($dataDto, 'json');

        return new JsonResponse(['data' => json_decode($item)]);
    }
}
