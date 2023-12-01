<?php

namespace App\Controller;

use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/map', name: 'app_map')]
class MapController extends AbstractController
{
    private $current = 'map';
    private $pageTitle = 'Төсөл хөтөлбөрүүд';
    private $columnSearch = [];

    #[Route('', name: 'app_map_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $mapRepo = $em->getRepository(Map::class);
        $map = $mapRepo->findAll();

        return $this->render('map/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Төсөл хөтөлбөр',
            'categories' => $map,
        ]);
    }
}
