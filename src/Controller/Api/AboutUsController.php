<?php

namespace App\Controller\Api;

use App\Entity\AboutUs;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/about-us', name: 'api_about')]
class AboutUsController extends AbstractController
{

    #[Route('/about-company', name: '_company', methods: ['get'])]
    public function getAboutUs(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $lang = $request->query->get('lang') ?: 'mn';

        $id = 1;
        $data = $entityManager->getRepository(AboutUs::class)->find($id);

        if (!$data) {
            return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        }

        $principles = '';
        $value = '';
        $vision = '';
        $strategyPurpose = '';
        $description = '';
        switch ($lang) {
            case 'mn':
                $principles = $data->getMnPrinciples();
                $value = $data->getMnValue();
                $vision = $data->getMnVision();
                $strategyPurpose = $data->getMnStrategyPurpose();
                $description = $data->getMnDescription();
                break;
            case 'en':
                $principles = $data->getEnPrinciples();
                $value = $data->getEnValue();
                $vision = $data->getEnVision();
                $strategyPurpose = $data->getEnStrategyPurpose();
                $description = $data->getEnDescription();

                break;
            case 'cn':
                $principles = $data->getCnPrinciples();
                $value = $data->getCnValue();
                $vision = $data->getCnVision();
                $strategyPurpose = $data->getCnStrategyPurpose();
                $description = $data->getCnDescription();

                break;
            default:
                $principles = $data->getMnPrinciples();
                $value = $data->getMnValue();
                $vision = $data->getMnVision();
                $strategyPurpose = $data->getMnStrategyPurpose();
                $description = $data->getMnDescription();

                break;
        }

        $dataDto = [
            'id' => $data->getId(),
            'value' => $value,
            'vision' => $vision,
            'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $data->getImageUrl(),
            'strategyPurpose' => $strategyPurpose,
            'principles' => $principles,
            'firstNumber' => $data->getFirsNumber(),
            'description' => $description,
            'secondNumber' => $data->getSecondNumber(),
            'thirdNumber' => $data->getThirdNumber(),
            'fourthNumber' => $data->getFourthNumber(),
        ];

        $serializedData = $serializer->serialize($dataDto, 'json');

        return new JsonResponse(['data' => json_decode($serializedData)]);
    }
}
