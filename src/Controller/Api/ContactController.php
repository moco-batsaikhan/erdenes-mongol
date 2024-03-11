<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact')]
    public function create(ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer): Response
    {
        $lang = $request->get('lang','mn');
        $contact = $doctrine
        ->getRepository(Contact::class)
        ->createQueryBuilder('p')
        ->getQuery()
        ->setMaxResults(1)
        ->getScalarResult();
        $contactDto = [
            'id' => $contact['p_id'],
            'address' => $contact['p_' . $lang . 'Address'],
            'email' => $contact['p_email'],
            'phone' => $contact['p_phone']
        ];

        $contact = $serializer->serialize($contactDto, 'json');
        $response = [
            'contact' => json_decode($contact)
        ];

        return new JsonResponse($response);
    }
}
