<?php

namespace App\Controller\Api;

use Exception;
use App\Entity\Strategy;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api', name: 'api_')]
class StrategyController extends AbstractController
{

    #[Route('/strategy/all/{page}', name: 'strategy_index', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getStrategy(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, $page): Response
    {
        try {
            $lang = $request->query->get('lang', 'mn');

            $pageSize = 20;

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', "e.{$lang}Title as title", "e.{$lang}Vision as vision", "e.{$lang}Purpose as purpose", "e.{$lang}Mission as mission", "e.{$lang}Target as target", "e.{$lang}Result as result",)
                ->where('e.active = 1')
                ->from(Strategy::class, 'e')
                ->setFirstResult(($page - 1) * $pageSize)
                ->setMaxResults($pageSize);

            $query = $qb->getQuery();
            $data = $query->getResult();

            $totalCount = $entityManager->createQueryBuilder()
                ->select('COUNT(e.id)')
                ->from(Strategy::class, 'e')
                ->andWhere('e.active = 1')
                ->getQuery()
                ->getSingleScalarResult();

            $strategyDatas = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($strategyDatas),
                'page' => $page,
                'pageSize' => $pageSize,
                'totalCount' => $totalCount
            ];

            return new JsonResponse($response);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/strategy/detail/{id}', name: 'strategy_id',  methods: ['GET'])]
    public function getEmployeeById(Request $request, $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            $lang = $request->query->get('lang', 'mn');

            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', "e.{$lang}Title as title", "e.{$lang}Vision as vision", "e.{$lang}Purpose as purpose", "e.{$lang}Mission as mission", "e.{$lang}Target as target", "e.{$lang}Result as result")
                ->from(Strategy::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->setParameter('id', $id)
                ->getQuery()
                ->getScalarResult();

            if (!$data) {
                throw new NotFoundHttpException('No ads found for id ' . $id);
            }

            if (!isset($data[0])) {
                return new JsonResponse(['code' => '404', 'message' => 'Not found strategy by id ' . $id]);
            }

            $data = $data[0];

            $strategyData = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($strategyData)
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
