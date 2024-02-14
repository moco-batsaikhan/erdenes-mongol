<?php

namespace App\Controller;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'app_')]
class FeedbackController extends AbstractController
{

    private $current = 'Feedback';
    private $pageTitle = 'Санал хүсэлт';

    #[Route('/feedback/{page}', name: 'feedback_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {
        $feedbackRepo = $em->getRepository(Feedback::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $map = $feedbackRepo->findAll();
        $data = $feedbackRepo->findBy([], null, $pageSize, $offset);

        return $this->render('feedback/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Санал хүсэлт',
            'feedbackDatas' => $data,
            'pageCount' => ceil(count($map) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_feedback_index'
        ]);
    }
}
