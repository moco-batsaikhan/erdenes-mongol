<?php

namespace App\Controller;

use App\Entity\Banner;
use App\Entity\CmsAdminLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\BannerCreateFormType;
use App\Form\BannerEditFormType;

#[Route('/banner', name: 'app_banner')]


class BannerController extends AbstractController
{

    private $current = 'banner';
    private $pageTitle = 'Баннер';
    private $columnSearch = [];


    #[Route('', name: '_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $bannerRepo = $em->getRepository(Banner::class);
        $banner = $bannerRepo->findAll();

        return $this->render('banner/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Баннер',
            'banners' => $banner,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $banner = new Banner;
        $bannerForm = $this->createForm(BannerCreateFormType::class, $banner);

        $bannerForm->handleRequest($request);

        if ($bannerForm->isSubmitted() && $bannerForm->isValid()) {
            try {

                $em->persist($banner);
                $em->flush();


                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($banner->getMnText());
                $log->setAction('Шинэ нүүр зураг үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_banner_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_banner_index');
        }

        return $this->render('banner/create.html.twig', [
            'bannerForm' => $bannerForm->createView(),
            'page_title' => 'Нүүр зураг',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $banner = $em->getRepository(Banner::class)->find($id);

        $editBannerForm = $this->createForm(BannerEditFormType::class, $banner, [
            'method' => 'POST',
        ]);

        $editBannerForm->handleRequest($request);

        if ($editBannerForm->isSubmitted() && $editBannerForm->isValid()) {

            $em->persist($banner);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($banner->getUsername());
            $log->setAction('Нүүр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_banner_edit', array('id' => $id));
        }


        return $this->render('banner/edit.html.twig', [
            'bannerForm' => $editBannerForm->createView(),
            'page_title' => 'Нүүр зураг засах',
        ]);
    }
}
