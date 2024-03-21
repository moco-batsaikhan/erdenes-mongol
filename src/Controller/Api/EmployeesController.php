<?php

namespace App\Controller\Api;

use App\Entity\Employee;
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
class EmployeesController extends AbstractController
{

    #[Route('/employees/list/{type}', name: 'employee_index',  methods: ['get'])]
    public function getEmployees($type,Request $request,EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $pageSize = 30;
        $page = $request->get('page') ? $request->get('page') : 1;
        $lang = $request->query->get('lang','mn');


        $qb = $entityManager->createQueryBuilder();
        $cloneQb = clone $qb;
        $count = $cloneQb->select('count(e.id)')->from(Employee::class, 'e')
        ->where('e.type = :type')->setParameter("type",$type)->getQuery()
        ->getSingleScalarResult();
        $qb->select('e.id', "e.{$lang}Name as name", 'e.priority', 'e.email', "e.{$lang}Division as division", 'e.image','e.phone',"e.{$lang}Experience as experience",'e.department','e.facebook','e.twitter')
            ->from(Employee::class, 'e')
            ->where('e.type = :type')
            ->setParameter("type",$type)
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
            'count' => $count,
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
            $qb->select('e.id, e.name, e.email, e.phone, e.division, e.image, e.priority, e.phone, e.department, e.experience, e.facebook,e.twitter')
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
