<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\PartnerOrganization;
use App\Form\PartnerOrganizationCreateTypeFormType;
use App\Form\PartnerOrganizationEditTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/partner/organization', name: 'app_partner_organization')]
class PartnerOrganizationController extends AbstractController

{

    private $current = 'partnerOrganization';
    private $pageTitle = 'Хамтрагч байгууллагууд';


    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $partnerOrganizationRepo = $em->getRepository(PartnerOrganization::class);
        $partnerOrganization = $partnerOrganizationRepo->findAll();

        return $this->render('partner_organization/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Хамтрагч байгууллагууд',
            'partnerOrganizations' => $partnerOrganization,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $partnerOrganization = new PartnerOrganization;
        $organizationForm = $this->createForm(PartnerOrganizationCreateTypeFormType::class, $partnerOrganization);

        $organizationForm->handleRequest($request);

        if ($organizationForm->isSubmitted() && $organizationForm->isValid()) {
            try {

                $em->persist($partnerOrganization);
                $em->flush();


                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($partnerOrganization->getName());
                $log->setAction('Шинэ нүүр зураг үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_partner_organization_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_banner_index');
        }

        return $this->render('partner_organization/create.html.twig', [
            'organizationForm' => $organizationForm->createView(),
            'page_title' => 'Хамтран ажиллагч байгууллага үүсгэх',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $partnerOrganization = $em->getRepository(PartnerOrganization::class)->find($id);

        $editOrganizationForm = $this->createForm(PartnerOrganizationEditTypeFormType::class, $partnerOrganization, [
            'method' => 'POST',
        ]);

        $editOrganizationForm->handleRequest($request);

        if ($editOrganizationForm->isSubmitted() && $editOrganizationForm->isValid()) {

            $em->persist($partnerOrganization);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($partnerOrganization->getUsername());
            $log->setAction('Нүүр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_partner_organization_edit', array('id' => $id));
        }


        return $this->render('partner_organization/edit.html.twig', [
            'organizationForm' => $editOrganizationForm->createView(),
            'page_title' => 'Хамтран ажиллагч байгууллага засах',
        ]);
    }
}
