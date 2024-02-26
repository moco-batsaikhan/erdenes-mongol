<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Organization;
use App\Form\OrganizationCreateFormType;
use App\Form\OrganizationEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/organization', name: 'app_organization')]


class OrganizationController extends AbstractController
{
    private $current = 'organization';
    private $pageTitle = 'Байгууллагууд';


    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {

        $organizationRepo = $em->getRepository(Organization::class);
        $organization = $organizationRepo->findAll();

        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $data = $organizationRepo->findBy([], null, $pageSize, $offset);

        return $this->render('organization/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Байгууллагууд',
            'organizations' => $data,
            'pageCount' => ceil(count($organization) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_organization_index'

        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $organization = new Organization;
        $organizationForm = $this->createForm(OrganizationCreateFormType::class, $organization);

        $organizationForm->handleRequest($request);

        if ($organizationForm->isSubmitted() && $organizationForm->isValid()) {

            $organization->setCreatedUser($this->getUser());
            $em->persist($organization);
            $em->flush();


            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($organization->getMnName());
            $log->setAction('Шинэ байгууллагийн мэдээлэл үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_organization_index');
        }

        return $this->render('organization/create.html.twig', [
            'organizationForm' => $organizationForm->createView(),
            'page_title' => 'Хамтран ажиллагч байгууллага үүсгэх',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $organization = $em->getRepository(Organization::class)->find($id);

        $editOrganizationForm = $this->createForm(OrganizationEditFormType::class, $organization, [
            'method' => 'POST',
        ]);

        $editOrganizationForm->handleRequest($request);

        if ($editOrganizationForm->isSubmitted() && $editOrganizationForm->isValid()) {

            $em->persist($organization);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($organization->getId());
            $log->setAction('Нүүр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_organization_index', array('id' => $id));
        }


        return $this->render('organization/edit.html.twig', [
            'organizationForm' => $editOrganizationForm->createView(),
            'page_title' => 'Хамтран ажиллагч байгууллага засах',
        ]);
    }
}
