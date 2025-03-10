<?php

namespace App\Controller;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $current = 'home';



    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {
        $feedbackRepo = $em->getRepository(Feedback::class);
        $pageSize = 5;
        $offset = ($page - 1) * $pageSize;
        $data = $feedbackRepo->findBy([], ['createdAt' => 'DESC'], $pageSize, $offset);
        $totalFeedbacks = $feedbackRepo->count([]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'feedbackDatas' => $data,
        ]);
    }
}
