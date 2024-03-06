<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResolutionController extends AbstractController
{
    #[Route('/resolution', name: 'app_resolution')]
    public function index(): Response
    {
        return $this->render('resolution/index.html.twig', [
            'controller_name' => 'ResolutionController',
        ]);
    }
}
