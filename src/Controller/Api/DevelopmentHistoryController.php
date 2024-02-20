<?php

namespace App\Controller\Api;

use App\Entity\DevelopmentHistory;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class DevelopmentHistoryController extends AbstractController
{

    #[Route('/development-history', name: '_development_history', methods: ['get'])]
    public function getDevelopmentHistory(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e.id', 'e.year', 'e.priority', 'e.file')
            ->from(DevelopmentHistory::class, 'e')
            ->orderBy('e.priority', 'ASC');

        $query = $qb->getQuery();
        $data = $query->getResult();

        $item = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($item)
        ];

        return new JsonResponse($response);
    }
}
