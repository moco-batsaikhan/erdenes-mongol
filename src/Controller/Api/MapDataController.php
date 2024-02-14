<?php

namespace App\Controller\Api;

use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api/map-data', name: 'api_')]
class MapDataController extends AbstractController
{

    #[Route('/all/{page}', name: 'all_map_data', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getMapData(EntityManagerInterface $entityManager, SerializerInterface $serializer, $page): Response
    {
        try {
            $pageSize = 10;

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', 'e.name', 'e.information', 'e.dataType', 'e.latitude', 'e.longitude')
                ->from(Map::class, 'e')
                ->setFirstResult(($page - 1) * $pageSize)
                ->setMaxResults($pageSize);

            $query = $qb->getQuery();
            $data = $query->getResult();

            $mapDatas = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($mapDatas),
                'page' => $page,
                'pagesize' => $pageSize
            ];

            return new JsonResponse($response);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'map_data_index',  methods: ['get'])]
    public function getMapDataById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', 'e.name', 'e.information', 'e.dataType', 'e.latitude', 'e.longitude')
                ->from(Map::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No map data found for id ' . $id);
            }

            $employeeData = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($employeeData)
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
