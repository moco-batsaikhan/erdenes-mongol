<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use App\Entity\JobAds;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api', name: 'api_')]
class JobAdsController extends AbstractController
{

    #[Route('/job-ads/{page}', name: 'ads_index', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getAds(EntityManagerInterface $entityManager, SerializerInterface $serializer, $page): Response
    {
        $pageSize = 10;

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e.id', 'e.title', 'e.profession', 'e.applicationDeadline', 'e.body', 'e.createdAt')
            ->from(JobAds::class, 'e')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $query = $qb->getQuery();
        $data = $query->getResult();

        $ads = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($ads),
            'page' => $page,
            'pagesize' => $pageSize
        ];

        return new JsonResponse($response);
    }

    #[Route('/ads/{id}', name: 'job_ad_index',  methods: ['GET'])]
    public function getEmployeeById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', 'e.title', 'e.profession', 'e.applicationDeadline', 'e.body', 'e.createdAt')
                ->from(JobAds::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No ads found for id ' . $id);
            }

            $adData = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($adData)
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
