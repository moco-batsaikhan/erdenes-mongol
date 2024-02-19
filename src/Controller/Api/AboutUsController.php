<?php

namespace App\Controller\Api;

use App\Entity\AboutUs;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/about-us', name: 'api_about')]
class AboutUsController extends AbstractController
{

    #[Route('/about-company', name: '_company', methods: ['get'])]
    public function getAboutUs(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        $id = 1;
        $data = $entityManager->getRepository(AboutUs::class)->find($id);

        $abouUs = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($abouUs)
        ];

        return new JsonResponse($response);
    }
}
