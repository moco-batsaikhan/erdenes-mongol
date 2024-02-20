<?php

namespace App\Controller\Api;

use App\Entity\CompanyStructure;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api', name: 'api_')]
class CompanyStructureController extends AbstractController
{

    #[Route('/company/structures/all/{page}', name: 'structure_index', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getCompanyStructures(EntityManagerInterface $entityManager, SerializerInterface $serializer, $page): Response
    {
        $pageSize = 10;

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e.id', 'e.name', 'e.phone', 'e.icon', 'e.web', 'e.address', 'e.body')
            ->from(CompanyStructure::class, 'e')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $query = $qb->getQuery();
        $data = $query->getResult();

        $structures = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($structures),
            'page' => $page,
            'pagesize' => $pageSize
        ];

        return new JsonResponse($response);
    }

    #[Route('/company/structure/{id}', name: 'structure_data_index',  methods: ['GET'])]
    public function getStructureById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id', 'e.name', 'e.phone', 'e.icon', 'e.web', 'e.address', 'e.body')
                ->from(CompanyStructure::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No employee found for id ' . $id);
            }

            foreach ($data as &$structure) {
                if ($structure['icon']) {
                    $structure['icon'] = $this->getParameter('base_url') . 'uploads/image/' . $structure['icon'];
                }
            }

            $structure = $serializer->serialize($data, 'json');

            $response = [
                'data' => json_decode($structure)
            ];

            return new JsonResponse($response);
        } catch (BadRequestHttpException | NotFoundHttpException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
