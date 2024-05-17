<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use App\Entity\JobAds;
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
class JobAdsController extends AbstractController
{

    #[Route('/job-ads', name: 'ads_index',  methods: ['get'])]
    public function getAds(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $pageSize = 10;
        $page = $request->get('page') ? $request->get('page') : 1;
        $lang = $request->query->get('lang', 'mn');

        $qb = $entityManager->createQueryBuilder();

        $qb->select('e')
            ->from(JobAds::class, 'e')
            ->where('e.active = 1')
            ->orderBy('e.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $query = $qb->getQuery();
        $data = $query->getResult();

        // if (!$data) {
        //     return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        // }

        $serializedAds = [];
        foreach ($data as $ad) {
            switch ($lang) {
                case 'mn':
                    $title = $ad->getTitle();
                    $body = $ad->getBody();
                    $profession = $ad->getProfession();
                    break;
                case 'en':
                    $title = $ad->getEnTitle();
                    $body = $ad->getEnBody();
                    $profession = $ad->getEnProfession();
                    break;
                case 'cn':
                    $title = $ad->getCnTitle();
                    $body = $ad->getCnBody();
                    $profession = $ad->getCnProfession();
                    break;
                default:
                    $title = $ad->getTitle();
                    $body = $ad->getBody();
                    $profession = $ad->getProfession();
                    break;
            }

            $dataDto = [
                'id' => $ad->getId(),
                'body' => $body,
                'title' => $title,
                'profession' => $profession,
                'applicationDeadline' => $ad->getApplicationDeadline()->format('Y-m-d\TH:i:sP'),
                'createdAt' => $ad->getCreatedAt()->format('Y-m-d\TH:i:sP')
            ];

            $serializedAds[] = $dataDto;
        }

        $response = [
            'data' => $serializedAds,
            'count' => count($serializedAds),
            'page' => $page,
            'pagesize' => $pageSize
        ];

        return new JsonResponse($response);
    }

    #[Route('/ads/{id}', name: 'job_ad_index',  methods: ['GET'])]
    public function getEmployeeById(Request $request, $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        try {
            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }
            $lang = $request->query->get('lang', 'mn');


            $qb = $entityManager->createQueryBuilder();
            $qb->select('e')
                ->from(JobAds::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No ads found for id ' . $id);
            }

            switch ($lang) {
                case 'mn':
                    $title = $data->getTitle();
                    $body = $data->getBody();
                    $profession = $data->getProfession();
                    break;
                case 'en':
                    $title = $data->getEnTitle();
                    $body = $data->getEnBody();
                    $profession = $data->getEnProfession();
                    break;
                case 'cn':
                    $title = $data->getCnTitle();
                    $body = $data->getCnBody();
                    $profession = $data->getCnProfession();
                    break;
                default:
                    $title = $data->getTitle();
                    $body = $data->getBody();
                    $profession = $data->getProfession();
                    break;
            }

            $adData = [
                'id' => $data->getId(),
                'body' => $body,
                'title' => $title,
                'profession' => $profession,
                'applicationDeadline' => $data->getApplicationDeadline()->format('Y-m-d'),
                'createdAt' => $data->getCreatedAt()->format('Y-m-d')
            ];

            // if (!isset($data[0])) {
            //     return new JsonResponse(['code' => '404', 'message' => 'Not found news by id ' . $id]);
            // }

            // $data = $data[0];

            // $adData = $serializer->serialize($data, 'json');

            $response = [
                'data' => $adData,
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
