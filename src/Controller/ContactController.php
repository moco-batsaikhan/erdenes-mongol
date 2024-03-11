<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Contact;
use App\Entity\Feedback;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact', name: 'app_contact')]
class ContactController extends AbstractController
{
    private $current = 'Contact';
    private $pageTitle = 'Холбоо барих';


    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {
        $contactRepo = $em->getRepository(Contact::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $map = $contactRepo->findAll();
        $data = $contactRepo->findBy([], null, $pageSize, $offset);

        return $this->render('contact/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Санал хүсэлт',
            'data' => $data,
            'pageCount' => ceil(count($map) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_contact_index'
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function create($id,EntityManagerInterface $em, Request $request): Response
    {

        $contact = $em->getRepository(Contact::class)->find($id);
        $contactForm = $this->createForm(ContactType::class, $contact);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {

            $em->persist($contact);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue(json_encode($contact));
            $log->setAction('Холбоо барих мэдээлэл шинчлэв үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_contact_index');
        }

        return $this->render('contact/edit.html.twig', [
            'contactForm' => $contactForm->createView(),
            'page_title' => 'Холбоо барих',
        ]);
    }
}
