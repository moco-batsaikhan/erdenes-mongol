<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin-log', name: 'app_admin_log')]
class AdminLogController extends AbstractController
{
    private $current = 'admin';
    private $pageTitle = 'Админ удирдлага';

    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(Request $request, EntityManagerInterface $em, $page = 1): Response
    {
        $userRepo = $em->getRepository(CmsAdminLog::class);
        $pageSize = 30;
        $data = $userRepo->getAllData($page, $pageSize);


        return $this->render('adminlog/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Админ лог',
            'adminlog' => $data['data'],
            'pageCount' => $data['pageCount'],
            'currentPage' => $page,
            'pageRoute' => 'app_admin_log_index'
        ]);
    }
}
