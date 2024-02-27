<?php

namespace App\Controller\Api;

use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api/map-data', name: 'api_')]
class MapDataController extends AbstractController
{

    #[Route('/all/{type}/{page}', name: 'all_map_data', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getMapData(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, $page, $type): Response
    {
        try {
            $lang = $request->query->get('lang', 'mn');

            $pageSize = 20;

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', "e.{$lang}Name as name", "e.{$lang}Description as description", 'e.dataType', 'e.latitude', 'e.longitude')
                ->where('e.active = 1')
                ->from(Map::class, 'e')
                ->setFirstResult(($page - 1) * $pageSize)
                ->setMaxResults($pageSize);

            if ($type !== 'ALL') {
                $qb->andWhere('e.dataType = :type')
                    ->setParameter('type', $type);
            }

            $query = $qb->getQuery();
            $data = $query->getResult();



            $totalCount = $entityManager->createQueryBuilder()
                ->select('COUNT(e.id)')
                ->from(Map::class, 'e')
                ->andWhere('e.active = 1')
                ->getQuery()
                ->getSingleScalarResult();

            $mapDatas = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($mapDatas),
                'page' => $page,
                'pageSize' => $pageSize,
                'totalCount' => $totalCount
            ];

            return new JsonResponse($response);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'map_data_index',  methods: ['get'])]
    public function getMapDataById(Request $request, $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            $lang = $request->query->get('lang', 'mn');

            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', "e.{$lang}Description as description",  'e.dataType', 'e.latitude', 'e.longitude', "e.{$lang}Body as body", "e.createdAt", "e.imageUrl", "e.{$lang}Name as name")
                ->from(Map::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No map data found for id ' . $id);
            }

            $imageUrl = "";
            if ($data) {
                $imageUrl = $this->getParameter('base_url') . 'uploads/image/' . $data->getImageUrl();
            }

            $employeeData = $serializer->serialize($data, 'json');
            $employeeData['imageUrl'] =  $imageUrl;


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
