<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\NewsType;
use App\Form\NewsTypeCreateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/news/type', name: 'app_news_type')]
class NewsTypeController extends AbstractController
{
    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $newsTypeRepo = $em->getRepository(NewsType::class);
        $newsType = $newsTypeRepo->findAll();

        return $this->render('news_type/index.html.twig', [
            'page_title' => 'Мэдээний төрөл',
            'newsTypes' => $newsType,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $newsType = new NewsType;
        $newsTypeForm = $this->createForm(NewsTypeCreateFormType::class, $newsType);

        $newsTypeForm->handleRequest($request);

        if ($newsTypeForm->isSubmitted() && $newsTypeForm->isValid()) {
            $em->persist($newsType);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($newsType->getId());
            $log->setAction('Шинэ Мэдээний төрөл үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_news_type_index');
        }

        return $this->render('news_type/create.html.twig', [
            'newsForm' => $newsTypeForm->createView(),
            'page_title' => 'Мэдээний төрөл',
        ]);
    }
}
