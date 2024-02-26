<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class CurrencyController extends AbstractController
{
    // #[Route('/currency', name: 'currency_api',  methods: ['get'])]
    // public function show(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    // {


    //     $currency = $serializer->serialize($data, 'json');

    //     $response = [
    //         'data' => json_decode($currency),
    //     ];

    //     return new JsonResponse($response);
    // }
}
