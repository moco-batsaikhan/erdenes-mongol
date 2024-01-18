<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Employee;
use App\Form\EmployeeCreateFormType;
use App\Form\EmployeeEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee', name: 'app_employee')]
class EmployeeController extends AbstractController
{
    private $current = 'employee';
    private $pageTitle = 'Хамт олон';

    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $employeeRepo = $em->getRepository(Employee::class);
        $employee = $employeeRepo->findAll();

        return $this->render('employee/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Хамт олон',
            'items' => $employee,
        ]);
    }

    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $employee = new Employee;
        $employeeForm = $this->createForm(EmployeeCreateFormType::class, $employee);

        $employeeForm->handleRequest($request);

        if ($employeeForm->isSubmitted() && $employeeForm->isValid()) {
            try {

                $em->persist($employee);
                $em->flush();


                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($employee->getName());
                $log->setAction('Шинэ ажилтаны мэдээлэл үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_employee_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_employee_index');
        }

        return $this->render('employee/create.html.twig', [
            'employeeForm' => $employeeForm->createView(),
            'page_title' => 'Шинэ ажилтаны мэдээлэл үүсгэв',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $employee = $em->getRepository(Employee::class)->find($id);

        $editEmployeeForm = $this->createForm(EmployeeEditFormType::class, $employee, [
            'method' => 'POST',
        ]);

        $editEmployeeForm->handleRequest($request);

        if ($editEmployeeForm->isSubmitted() && $editEmployeeForm->isValid()) {

            $em->persist($employee);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($employee->getUsername());
            $log->setAction('Ажилтаны мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_employee_edit', array('id' => $id));
        }


        return $this->render('employee/edit.html.twig', [
            'employeeForm' => $editEmployeeForm->createView(),
            'page_title' => 'Ажилтаны мэдээлэл засах',
        ]);
    }
}
