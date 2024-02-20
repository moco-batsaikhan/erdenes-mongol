<?php

namespace App\Controller\Api;

use App\Entity\Layout;
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
class SectionController extends AbstractController
{
    #[Route('/section', name: 'section_index',  methods: ['get'])]
    public function show(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $data = $entityManager->getRepository(Layout::class)->findBy(
            [],
            [
                'priority' => 'ASC'
            ]
        );

        $section = $serializer->serialize($data, 'json');


        $response = [
            'data' => json_decode($section)
        ];

        return new JsonResponse($response);
    }
}
