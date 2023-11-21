<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Omines\DataTablesBundle\Exporter\DataTableExporterEvents;
use Omines\DataTablesBundle\Exporter\Event\DataTableExporterResponseEvent;

class AdminController extends AbstractController
{
    // private $current = 'admin';
    // private $pageTitle = 'Админ удирдлага';
    // private $columnSearch = [];


    #[Route('/', name: 'app_admin')]
    public function index(Request $request): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);


        // $options = [
        //     'fixedHeader' => false,
        //     'serverSide' => true,
        //     'processing' => true,
        //     'searching' => true,
        //     'autoWidth' => true,
        // ];


        // $table = $dataTableFactory->create($options);
    }
}
