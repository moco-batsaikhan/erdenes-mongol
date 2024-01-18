<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\SubCategory;
use App\Form\SubCategoryCreateFormType;
use App\Form\SubCategoryEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sub/category', name: 'app_sub_category')]


class SubCategoryController extends AbstractController

{

    private $current = 'subCategory';
    private $pageTitle = 'Туслах цэс';
    private $columnSearch = [];


    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {


        $subCatRepo = $em->getRepository(SubCategory::class);
        $subCategory = $subCatRepo->findAll();

        return $this->render('sub_category/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Туслах цэс',
            'categories' => $subCategory,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $subCategory = new SubCategory;
        $subCategoryForm = $this->createForm(SubCategoryCreateFormType::class, $subCategory);

        $subCategoryForm->handleRequest($request);

        if ($subCategoryForm->isSubmitted() && $subCategoryForm->isValid()) {
            $subCategory->setCreatedUser($this->getUser());

            $em->persist($subCategory);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($subCategory->getMnName());
            $log->setAction('Шинэ туслах цэс үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_sub_category_index');
        }

        return $this->render('sub_category/create.html.twig', [
            'subCategoryForm' => $subCategoryForm->createView(),
            'page_title' => 'Туслах цэс',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $subCategory = $em->getRepository(SubCategory::class)->find($id);

        $editSubCategoryForm = $this->createForm(SubCategoryEditFormType::class, $subCategory, [
            'method' => 'POST',
        ]);

        $editSubCategoryForm->handleRequest($request);

        if ($editSubCategoryForm->isSubmitted() && $editSubCategoryForm->isValid()) {

            $em->persist($subCategory);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($subCategory->getId());
            $log->setAction('Админ туслах цэс засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();


            $this->addFlash('success', 'Амжилттай засагдлаа.');

            return $this->redirectToRoute('app_sub_category_edit', array('id' => $id));
        }


        return $this->render('sub_category/edit.html.twig', [
            'subCategoryForm' => $editSubCategoryForm->createView(),
            'page_title' => 'Цэс засах',
        ]);
    }
}
