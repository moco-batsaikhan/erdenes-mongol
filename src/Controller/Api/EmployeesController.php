<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[Route('/api', name: 'api_')]
class EmployeesController extends AbstractController
{

    #[Route('/employees/{page}', name: 'employee_index', requirements: ['page' => '\d+'], defaults: ['page' => 1],  methods: ['get'])]
    public function getEmployees(EntityManagerInterface $entityManager, SerializerInterface $serializer, $page): Response
    {
        $pageSize = 10;

        $qb = $entityManager->createQueryBuilder();
        $qb->select('e.id', 'e.name', 'e.priority', 'e.email', 'e.division', 'e.image', 'e.department')
            ->from(Employee::class, 'e')
            ->orderBy('e.priority', 'ASC')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $query = $qb->getQuery();
        $data = $query->getResult();


        foreach ($data as &$employee) {
            if ($employee['image']) {
                $employee['image'] = $this->getParameter('base_url') . 'uploads/image/' . $employee['image'];
            }
        }

        $employees = $serializer->serialize($data, 'json');

        $response = [
            'data' => json_decode($employees),
            'page' => $page,
            'pagesize' => $pageSize
        ];

        return new JsonResponse($response);
    }

    #[Route('/employee/{id}', name: 'employee_data_index',  methods: ['GET'])]
    public function getEmployeeById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            if (!$id) {
                throw new BadRequestHttpException('Parameter "id" is required.');
            }

            $qb = $entityManager->createQueryBuilder();
            $qb->select('e.id, e.name, e.email, e.phone, e.division, e.image, e.priority, e.department')
                ->from(Employee::class, 'e')
                ->where('e.id = :id')
                ->setParameter('id', $id);

            $data = $qb->getQuery()->getOneOrNullResult();

            if (!$data) {
                throw new NotFoundHttpException('No employee found for id ' . $id);
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
