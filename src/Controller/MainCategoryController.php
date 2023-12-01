<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\MainCategory;
use App\Form\MainCategoryCreateFormType;
use App\Form\MainCategoryEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main/category', name: 'app_main_category')]
class MainCategoryController extends AbstractController
{


    private $current = 'mainCategory';
    private $pageTitle = 'Үндсэн цэс';
    private $columnSearch = [];


    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $mainCatRepo = $em->getRepository(MainCategory::class);
        $mainCategory = $mainCatRepo->findAll();

        return $this->render('main_category/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Үндсэн цэс',
            'categories' => $mainCategory,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $mainCategory = new MainCategory;
        $mainCategoryForm = $this->createForm(MainCategoryCreateFormType::class, $mainCategory);

        $mainCategoryForm->handleRequest($request);

        if ($mainCategoryForm->isSubmitted() && $mainCategoryForm->isValid()) {
            try {
                dd($mainCategory);
                $em->persist($mainCategory);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($mainCategory->getMnName());
                $log->setAction('Шинэ цэс үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_main_category_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_main_category_index');
        }

        return $this->render('main_category/create.thml.twig', [
            'mainCategoryForm' => $mainCategoryForm->createView(),
            'page_title' => 'Үндсэн цэс',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $mainCategory = $em->getRepository(MainCategory::class)->find($id);

        $editMainCategoryForm = $this->createForm(MainCategoryEditFormType::class, $mainCategory, [
            'method' => 'POST',
        ]);

        $editMainCategoryForm->handleRequest($request);

        if ($editMainCategoryForm->isSubmitted() && $editMainCategoryForm->isValid()) {

            $em->persist($mainCategory);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            // $log->setValue($user->getUsername());
            $log->setAction('Админ мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();


            $this->addFlash('success', 'Амжилттай засагдлаа.');

            return $this->redirectToRoute('app_main_category_edit', array('id' => $id));
        }


        return $this->render('main_category/edit.html.twig', [
            'categoryForm' => $editMainCategoryForm->createView(),
            'page_title' => 'Цэс засах',
        ]);
    }
}
