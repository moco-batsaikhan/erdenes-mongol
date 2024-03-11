<?php

namespace App\Controller\Api;

use App\Entity\CompanyStructure;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class CompanyStructureController extends AbstractController
{

    #[Route('/company/structures/all', name: 'structure_index',  methods: ['get'])]
    public function getCompanyStructures(Request $request,EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {


        $lang = $request->get('lang') ? $request->get('lang') : 'mn';


        $data = $entityManager
        ->getRepository(CompanyStructure::class)
        ->createQueryBuilder('p')
        ->getQuery()
        ->getScalarResult();

        $dto = [];
        foreach ($data as $key => $value) {
            $dto[] = [
                'id' => $value['p_id'],
                'title' => $value['p_' . $lang . 'Name'],
                'phone' => $value['p_phone'],
                'icon' => $this->getParameter('base_url') . 'uploads/image/' . $value['p_icon'],
                'web' => $value['p_web'],
                'address' => $value['p_' . $lang . 'Address'],
                'body' => $value['p_' . $lang . 'Body']
            ];
        }



        $structures = $serializer->serialize($dto, 'json');

        $response = [
            'data' => json_decode($structures),
        ];

        return new JsonResponse($response);
    }

}
