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

        // if (!isset($data[0])) {
        //     return new JsonResponse(['code' => '404', 'message' => 'Not found data by id ' . $id]);
        // }
        // $data = $data[0];

        $principles = '';
        $purpose = '';
        $vision = '';
        $slogan = '';
        $description = '';
        switch ($lang) {
            case 'mn':
                $principles = $data->getMnPrinciples();
                $purpose = $data->getMnPurpose();
                $vision = $data->getMnVision();
                $slogan = $data->getMnSlogan();
                $description = $data->getMnDescription();
                break;
            case 'en':
                $principles = $data->getEnPrinciples();
                $purpose = $data->getEnPurpose();
                $vision = $data->getEnVision();
                $slogan = $data->getEnSlogan();
                $description = $data->getEnDescription();

                break;
            case 'cn':
                $principles = $data->getCnPrinciples();
                $purpose = $data->getCnPurpose();
                $vision = $data->getCnVision();
                $slogan = $data->getCnSlogan();
                $description = $data->getCnDescription();

                break;
            default:
                $principles = $data->getMnPrinciples();
                $purpose = $data->getMnPurpose();
                $vision = $data->getMnVision();
                $slogan = $data->getMnSlogan();
                $description = $data->getMnDescription();

                break;
        }

        $dataDto = [
            'id' => $data->getId(),
            'purpose' => $purpose,
            'vision' => $vision,
            'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $data->getImageUrl(),
            'slogan' => $slogan,
            'principles' => $principles,
            'firstNumber' => $data->getFirsNumber(),
            'description' => $description,
            'secondNumber' => $data->getSecondNumber(),
        ];

        $serializedData = $serializer->serialize($dataDto, 'json');

        return new JsonResponse(['data' => json_decode($serializedData)]);
    }
}
