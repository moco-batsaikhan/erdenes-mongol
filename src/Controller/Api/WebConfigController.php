<?php

namespace App\Controller\Api;

use App\Entity\WebConfig;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class WebConfigController extends AbstractController
{
    #[Route('/web-config', name: 'web_config_index',  methods: ['get'])]
    public function getWebConfig(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $webConfig = $entityManager->getRepository(WebConfig::class)->findOneBy([]);

        if (!$webConfig) {
            return new JsonResponse(['message' => 'No web config found'], Response::HTTP_NOT_FOUND);
        }

        $webConfigDto = [
            'id' => $webConfig->getId(),
            'transparentImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getTransparentImage(),
            'sloganImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getSloganImage(),
            'coverImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getCoverImage(),
            'textColor' => $webConfig->getColorCode(),
            'backgroundColor' => $webConfig->getBackgroundColor()
        ];

        $webConfig = $serializer->serialize($webConfigDto, 'json');

        $response = [
            'data' => json_decode($webConfig)
        ];

        return new JsonResponse($response);
    }
}
