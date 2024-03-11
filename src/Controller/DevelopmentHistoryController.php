<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\DevelopmentHistory;
use App\Form\DevelopmentHistoryCreateFormType;
use App\Form\DevelopmentHistoryEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;


#[Route('/development/history', name: 'app_development_history')]
class DevelopmentHistoryController extends AbstractController
{

    private $pageTitle = 'Хөгжлийн түүх';

    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {
        $developmentHistoryRepo = $em->getRepository(DevelopmentHistory::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $developmentHistory = $developmentHistoryRepo->findAll();
        $data = $developmentHistoryRepo->findBy([], null, $pageSize, $offset);

        return $this->render('development_history/index.html.twig', [
            'page_title' => $this->pageTitle,
            'section_title' => $this->pageTitle,
            'items' => $data,
            'pageCount' => ceil(count($developmentHistory) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_development_history_index'
        ]);
    }



    #[Route('/create', name: '_create')]
    public function createChartData(EntityManagerInterface $em, Request $request): Response
    {
        $developmentHistory = new DevelopmentHistory;
        $myForm = $this->createForm(DevelopmentHistoryCreateFormType::class, $developmentHistory);

        $myForm->handleRequest($request);

        if ($myForm->isSubmitted() && $myForm->isValid()) {


            $developmentHistory->setCreatedUser($this->getUser());

            $em->persist($developmentHistory);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($developmentHistory->getId());
            $log->setAction('Хөгжлийн түүх шинээр үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_development_history_index');
        }

        return $this->render('development_history/create.html.twig', [
            'myForm' => $myForm->createView(),
            'page_title' => 'Хөгжлийн түүх',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {


        $item = $em->getRepository(DevelopmentHistory::class)->find($id);

        $developmentHistoryForm = $this->createForm(DevelopmentHistoryEditFormType::class, $item, [
            'method' => 'POST',
        ]);

        $developmentHistoryForm->handleRequest($request);

        if ($developmentHistoryForm->isSubmitted() && $developmentHistoryForm->isValid()) {
            
            $em->persist($item);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($item->getId());
            $log->setAction('Хөгжлийн түүх мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_development_history_index', array('id' => $id));
        }


        return $this->render('development_history/edit.html.twig', [
            'myForm' => $developmentHistoryForm->createView(),
            'page_title' => 'Хөгжлийн түүх',
        ]);
    }

}
