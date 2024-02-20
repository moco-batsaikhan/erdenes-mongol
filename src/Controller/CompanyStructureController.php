<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\CompanyStructure;
use App\Form\StructureCreateFormType;
use App\Form\StructureEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/structure', name: 'app_structure')]

class CompanyStructureController extends AbstractController
{

    private $current = 'companyStructure';
    private $pageTitle = 'Компаний бүтэц';

    #[Route('/index', name: '_index')]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {

        $structureRepo = $em->getRepository(CompanyStructure::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $structure = $structureRepo->findAll();
        $data = $structureRepo->findBy([], null, $pageSize, $offset);

        return $this->render('company_structure/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Компаний бүтэц',
            'structure' => $data,
            'pageCount' => ceil(count($structure) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_structure_index'
        ]);
    }

    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $structure = new CompanyStructure;
        $structureForm = $this->createForm(StructureCreateFormType::class, $structure);

        $structureForm->handleRequest($request);

        if ($structureForm->isSubmitted() && $structureForm->isValid()) {
            try {
                $em->persist($structure);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($structure->getName());
                $log->setAction('Шинэ компаний бүтцийн мэдээлэл үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_structure_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_structure_index');
        }

        return $this->render('company_structure/create.html.twig', [
            'structureForm' => $structureForm->createView(),
            'page_title' => 'Нүүр зураг',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $structure = $em->getRepository(CompanyStructure::class)->find($id);

        $editStructureForm = $this->createForm(StructureEditFormType::class, $structure, [
            'method' => 'POST',
        ]);

        $editStructureForm->handleRequest($request);

        if ($editStructureForm->isSubmitted() && $editStructureForm->isValid()) {

            $em->persist($structure);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($structure->getName());
            $log->setAction('компаний бүтцийн мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_structure_index', array('id' => $id));
        }


        return $this->render('company_structure/edit.html.twig', [
            'structureForm' => $editStructureForm->createView(),
            'page_title' => 'Нүүр зураг засах',
        ]);
    }
}
