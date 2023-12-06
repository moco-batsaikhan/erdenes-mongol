<?php

namespace App\Controller;

use App\Entity\CategoryClick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/category/click', name: 'app_category_click')]
class CategoryClickController extends AbstractController
{

    private $current = 'catClick';
    private $pageTitle = 'Мэдээ болон цэс холбоос';
    private $columnSearch = [];


    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $itemRepo = $em->getRepository(CategoryClick::class);
        $item = $itemRepo->findAll();

        return $this->render('category_click/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ болон цэс холбоос',
            'items' => $item,
        ]);
    }
}
