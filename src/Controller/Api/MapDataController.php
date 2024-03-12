<?php

namespace App\Controller\Api;

use App\Entity\Map;
use App\Entity\MapType;
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

            $qb = $entityManager->getRepository(Map::class)->createQueryBuilder('e');
            $qb->leftjoin('App\Entity\MapType', 'mt', \Doctrine\ORM\Query\Expr\Join::WITH, 'mt.id = e.mapType')
                ->select("e.id, e.{$lang}Name as name, e.{$lang}Description, mt.{$lang}Name as dataType, e.latitude, e.longitude")
                ->where('e.active = 1')
                ->setFirstResult(($page - 1) * $pageSize)
                ->setMaxResults($pageSize);

            if ($type !== 'ALL') {
                 $qb->andWhere('mt.id = :type')
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

    #[Route('/type/list/{page}', name: 'map_data_type_index', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getMapTypeData(Request $request, $page, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            $lang = $request->query->get('lang', 'mn');
            $pageSize = 20;

            $qb = $entityManager->getRepository(MapType::class)->createQueryBuilder('e');
            $qb->select('e.id',  "e.${lang}Name as name", 'e.active')
            ->where('e.active = 1')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

            $query = $qb->getQuery();
            $data = $query->getResult();
            $totalCount = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(MapType::class, 'e')
            ->andWhere('e.active = 1')
            ->getQuery()
            ->getSingleScalarResult();

            $typeData = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($typeData),
                'page' => $page,
                'pageSize' => $pageSize,
                'totalCount' => $totalCount
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
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

            $qb = $entityManager->getRepository(Map::class)->createQueryBuilder('e');
            $qb->leftjoin('App\Entity\MapType', 'mt', \Doctrine\ORM\Query\Expr\Join::WITH, 'mt.id = e.mapType')
                ->select('e.id', "e.{$lang}Description as description",  "mt.${lang}Name as dataType", 'e.latitude', 'e.longitude', "e.{$lang}Body as body", "e.createdAt", "e.imageUrl", "e.{$lang}Name as name")
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getSingleResult();

            if (!$data) {
                throw new NotFoundHttpException('No map data found for id ' . $id);
            }


            if ($data) {
                $data['imageUrl'] = $this->getParameter('base_url') . 'uploads/image/' . $data['imageUrl'];
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
