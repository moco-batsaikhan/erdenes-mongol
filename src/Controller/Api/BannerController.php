<?php

namespace App\Controller\Api;

use App\Entity\Banner;
use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class BannerController extends AbstractController
{
    #[Route('/banner', name: 'banner_index',  methods: ['get'])]
    public function show(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        $lang = $request->query->get('lang', 'mn');

        $data = $entityManager->getRepository(Banner::class)->createQueryBuilder('b')->where('b.active = 1')->orderBy('b.id', "DESC")->getQuery()
            ->getScalarResult();

        if (!$data) {
            $data = $entityManager->getRepository(Banner::class)->createQueryBuilder('b')
                ->orderBy('b.id', "DESC")->getQuery()
                ->setMaxResults(1)->getScalarResult();
        }

        $icon = '';
        switch ($lang) {
            case 'mn':
                $icon = $data[0]['b_icon'];
                break;
            case 'en':
                $icon = $data[0]['b_enIcon'];
                break;
            case 'cn':
                $icon = $data[0]['b_enIcon'];
                break;
            default:
                $icon = $data[0]['b_icon'];
                break;
        }

        $bannerDto = [
            'id' => $data[0]['b_id'],
            'imageUrl' => $this->getParameter('base_url') . 'uploads/image/' . $data[0]['b_imageUrl'],
            'icon' => $icon,
            'active' => $data[0]['b_active']
        ];

        $banner = $serializer->serialize($bannerDto, 'json');

        $response = [
            'data' => json_decode($banner)
        ];

        return new JsonResponse($response);
    }
}
