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

        if (!$data) {
            return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        foreach ($data as &$item) {
            if ($item->getImageUrl()) {
                $item->setImageUrl($this->getParameter('base_url') . 'uploads/image/' . $item->getImageUrl());
            }
        }

        $serializedData = $serializer->serialize($data, 'json');

        return new JsonResponse(['data' => json_decode($serializedData)]);
    }
}
