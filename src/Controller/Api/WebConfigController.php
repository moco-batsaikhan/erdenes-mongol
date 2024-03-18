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
    #[Route('/web-config', name: 'web_config_index', methods: ['get'])]
    public function getWebConfig(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $lang = $request->query->get('lang') ?: 'mn';

        $webConfig = $entityManager->getRepository(WebConfig::class)->findOneBy([]);

        if (!$webConfig) {
            return new JsonResponse(['message' => 'No web config found'], Response::HTTP_NOT_FOUND);
        }

        $slogan = '';
        switch ($lang) {
            case 'mn':
                $slogan = $webConfig->getMnSloganText();
                break;
            case 'en':
                $slogan = $webConfig->getEnSloganText();
                break;
            case 'cn':
                $slogan = $webConfig->getCnSloganText();
                break;
            default:
                $slogan = $webConfig->getMnSloganText();
                break;
        }

        $footerText = '';
        switch ($lang) {
            case 'mn':
                $footerText = $webConfig->getMnFooterText();
                break;
            case 'en':
                $footerText = $webConfig->getEnFooterText();
                break;
            case 'cn':
                $footerText = $webConfig->getCnFooterText();
                break;
            default:
                $footerText = $webConfig->getMnFooterText();
                break;
        }

        $webConfigDto = [
            'id' => $webConfig->getId(),
            'transparentImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getTransparentImage(),
            'sloganImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getSloganImage(),
            'coverImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getCoverImage(),
            'contactImage' => $this->getParameter('base_url') . 'uploads/image/' . $webConfig->getContactImage(),
            'textColor' => $webConfig->getColorCode(),
            'backgroundColor' => $webConfig->getBackgroundColor(),
            'sloganText' => $slogan,
            'footerText' => $footerText
        ];

        $webConfig = $serializer->serialize($webConfigDto, 'json');

        $response = [
            'data' => json_decode($webConfig)
        ];

        return new JsonResponse($response);
    }
}
