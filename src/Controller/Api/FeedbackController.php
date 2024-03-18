<?php

namespace App\Controller\Api;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class FeedbackController extends AbstractController
{

    #[Route('/feedback', name: 'feedback_create',  methods: ['post'])]
    public function create(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['email'], $data['feedback'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $feedback = new Feedback();
        $feedback->setName($data['name']);
        $feedback->setEmail($data['email']);
        $feedback->setFeedback($data['feedback']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($feedback);
        $em->flush();

        return new JsonResponse(['message' => 'Feedback received successfully'], JsonResponse::HTTP_CREATED);
    }
}
