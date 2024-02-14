<?php
namespace App\Controller\Api;
use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api', name:'api_')]
class OrganizationController extends AbstractController
{
    #[Route('/organization', name:'organization_index', methods: ['get'])]
    public function show(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $data = $entityManager->getRepository(Organization::class)->findAll();

        $organization = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($organization),
        ];

        return new JsonResponse($response);
    }
}