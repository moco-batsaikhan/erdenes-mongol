<?php

namespace App\Controller;

use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/section', name: 'app_section')]
class SectionController extends AbstractController
{

    private $current = 'section';
    private $pageTitle = 'Видео мэдээлэл';

    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {

        $sectionRepo = $em->getRepository(Layout::class);
        $section = $sectionRepo->findAll();

        return $this->render('section/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Нүүр хэсгийн дараалал',
            'sections' => $section,
        ]);
    }
}
