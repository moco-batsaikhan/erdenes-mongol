<?php

namespace App\Controller\Api;

use App\Entity\Banner;
use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class BannerController extends AbstractController
{
    #[Route('/banner', name: 'banner_index',  methods: ['get'])]
    public function show(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $data = $entityManager->getRepository(Banner::class)->createQueryBuilder('b')->where('b.active = 1')->orderBy('b.id',"DESC")->getQuery()
        ->getScalarResult();

        if(!$data){
            $data = $entityManager->getRepository(Banner::class)->createQueryBuilder('b')
            ->orderBy('b.id',"DESC")->getQuery()
            ->setMaxResults(1)->getScalarResult();
        }

        
        $bannerDto = [
            'id' => $data[0]['b_id'],
            'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $data[0]['b_imageUrl'],
            'active' => $data[0]['b_active']
        ];

        $banner = $serializer->serialize($bannerDto, 'json');

        


        $response = [
            'data' => json_decode($banner)
        ];

        return new JsonResponse($response);
    }
}
