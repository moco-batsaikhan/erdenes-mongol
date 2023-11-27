<?php

namespace App\Controller;

use App\Entity\Banner;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Exporter\DataTableExporterEvents;
use Omines\DataTablesBundle\Exporter\Event\DataTableExporterResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Omines\DataTablesBundle\Column\TextColumn;
use App\Form\BannerCreateFormType;
//use App\Form\BannerEditFormType;
use Psr\Log\LoggerInterface;

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
}
