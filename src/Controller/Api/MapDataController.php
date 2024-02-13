<?php

namespace App\Controller\Api;

use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api/map-data', name: 'api_')]
class MapDataController extends AbstractController
{

    #[Route('/all/{page}', name: 'all_map_data', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function findAll(EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request): Response
    {
        try {
            $page = $request->attributes->getInt('page', 1);
            $repository = $entityManager->getRepository(Map::class);
            $totalItems = count($repository->findAll());

            if ($totalItems == 0) {
                throw new NotFoundHttpException(
                    'No product found'
                );
            }

            $itemsPerPage = 10;
            $pageCount = ceil($totalItems / $itemsPerPage);

            $datas = $repository->findBy([], null, $itemsPerPage, ($page - 1) * $itemsPerPage);

            if (!$datas) {
                throw new NotFoundHttpException(
                    'No product found'
                );
            }

            $mapDatas = $serializer->serialize($datas, 'json');

            $response = [
                'pageCount' => $pageCount,
                'pageSize' => $itemsPerPage,
                'data' => json_decode($mapDatas)
            ];

            return new JsonResponse(['data' => $response]);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'map_data_index',  methods: ['get'])]
    public function FindById(EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request): Response
    {
        try {

            $id = $request->query->get('id');

            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $data = $entityManager->getRepository(Map::class)->find($id);

            if (!$data) {
                throw new NotFoundHttpException(
                    'No product found for id ' . $id
                );
            }

            $mapData = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($mapData)
            ];

            return new JsonResponse(['data' => $response]);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
