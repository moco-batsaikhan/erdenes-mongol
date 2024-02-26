<?php

namespace App\Controller\Api;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/api', name: 'api_')]
class CurrencyController extends AbstractController
{
    #[Route('/currency', name: 'currency',  methods: ['get'])]
    public function show(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $date = $request->query->get('date');

        if (!$date) {
            throw new BadRequestHttpException('Parameter "date" is required.');
        }

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e.id, e.file, e.enFile, e.CurrencyDate')
            ->from(Currency::class, 'e')
            ->where('e.CurrencyDate = :date')
            ->setParameter('date', $date);

        $data = $qb->getQuery()->getOneOrNullResult();

        if (!$data) {
            throw new NotFoundHttpException('Таны оруулсан өдрийх ханшийн мэдээлэл ороогүй байна. ' . $date);
        }

        $currencyData = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($currencyData)
        ];

        return new JsonResponse($response);
    }
}
