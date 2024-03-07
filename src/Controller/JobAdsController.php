<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\JobAds;
use App\Form\JobAdsCreateFormType;
use App\Form\JobAdsEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job/ads', name: 'app_job_ads')]
class JobAdsController extends AbstractController
{

    private $current = 'job ads';
    private $pageTitle = 'Ажлын байрны зар';


    #[Route('/index/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {
        $adsRepo = $em->getRepository(JobAds::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $banner = $adsRepo->findAll();
        $data = $adsRepo->findBy([],  ["createdAt"=>"DESC"], $pageSize, $offset);

        return $this->render('job_ads/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Ажлын байрны зар',
            'ads' => $data,
            'pageCount' => ceil(count($banner) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_job_ads_index'
        ]);
    }

    #[Route('/create', name: '_create')]
    public function createJobAds(EntityManagerInterface $em, Request $request): Response
    {
        $ads = new JobAds();
        $adsForm = $this->createForm(JobAdsCreateFormType::class, $ads, [
            'method' => 'POST',
        ]);

        $adsForm->handleRequest($request);

        if ($adsForm->isSubmitted() && $adsForm->isValid()) {

            $em->persist($ads);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($ads->getId());
            $log->setAction('Ажлын байрны зар үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_job_ads_index');
        }

        return $this->render('job_ads/create.html.twig', [
            'form' => $adsForm->createView(),
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Нэмэх',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $ads = $em->getRepository(JobAds::class)->find($id);

        $editAdsForm = $this->createForm(JobAdsEditFormType::class, $ads, [
            'method' => 'POST',
        ]);

        $editAdsForm->handleRequest($request);

        if ($editAdsForm->isSubmitted() && $editAdsForm->isValid()) {

            $em->persist($ads);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($ads->getId());
            $log->setAction('Ажлын байрны зар засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_job_ads_index', array('id' => $id));
        }


        return $this->render('job_ads/edit.html.twig', [
            'form' => $editAdsForm->createView(),
            'page_title' => 'Ажлын байрны зар засах',
        ]);
    }
}
