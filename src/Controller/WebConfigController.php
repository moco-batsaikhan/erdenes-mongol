<?php

namespace App\Controller;

use App\Entity\WebConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/web/config', name: 'app_web_config')]


class WebConfigController extends AbstractController
{
    private $current = 'webconfig';
    private $pageTitle = 'Веб тохиргоо';
    private $columnSearch = [];

    #[Route('/index', name: '_index')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $configRepo = $em->getRepository(WebConfig::class);
        $config = $configRepo->find();

        return $this->render('config/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Баннер',
            'configs' => $config,
        ]);
    }
}
