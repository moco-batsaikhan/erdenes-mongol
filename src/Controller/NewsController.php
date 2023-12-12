<?php

namespace App\Controller;

use App\Entity\CategoryClick;
use App\Entity\CmsAdminLog;
use App\Entity\Content;
use App\Entity\News;
use App\Form\NewsCreateFormType;
use App\Form\NewsEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/news', name: 'app_news')]
class NewsController extends AbstractController
{

    private $current = 'news';
    private $pageTitle = 'Мэдээ';
    private $columnSearch = [];


    #[Route('', name: '_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        $newsRepo = $em->getRepository(News::class);
        $news = $newsRepo->findAll();

        return $this->render('news/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ',
            'news' => $news,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $news = new News;
        $newsForm = $this->createForm(NewsCreateFormType::class, $news);

        $newsForm->handleRequest($request);

        if ($newsForm->isSubmitted() && $newsForm->isValid()) {
            $news->setCreatedUser($this->getUser());

            $em->persist($news);
            $em->flush();



            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($news->getId());
            $log->setAction('Шинэ Мэдээ үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_news_index');
        }

        return $this->render('news/create.html.twig', [
            'newsForm' => $newsForm->createView(),
            'page_title' => 'Мэдээ',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $editNewsForm = $this->createForm(NewsEditFormType::class, $news, [
            'method' => 'POST',
        ]);

        $editNewsForm->handleRequest($request);

        if ($editNewsForm->isSubmitted() && $editNewsForm->isValid()) {

            $em->persist($news);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($news->getId());
            $log->setAction('Нүүр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_news_edit', array('id' => $id));
        }


        return $this->render('news/edit.html.twig', [
            'newsForm' => $editNewsForm->createView(),
            'page_title' => 'Нүүр зураг засах',
        ]);
    }

    #[Route('/choose-content', name: '_choose_content')]
    public function listIndex(): Response
    {

        return $this->render('news/choose-content.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
        ]);
    }

    #[Route('/publish/{id}', name: '_punlish', requirements: ['id' => "\d+"])]
    public function publish($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $news->setProcessType('PUBLISHED');

        $em->persist($news);
        $em->flush();

        $log = new CmsAdminLog();
        // $log->setAdminname($this->getUser());
        $log->setIpaddress($request->getClientIp());
        $log->setValue($news->getId());
        $log->setAction('Мэдээ нийтлэв.');
        $log->setCreatedAt(new \DateTime('now'));

        $em->persist($log);
        $em->flush();

        $this->addFlash('success', 'Амжилттай нийтлэгдлээ.');
        return $this->redirectToRoute('app_news_index');
    }


    #[Route('/news/{id}/contents', name: '_contents', requirements: ['id' => "\d+"])]
    public function contents($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $contents = $em->getRepository(Content::class)->findBy(['News' => $news]);


        return $this->render('news/contents.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ',
            'contents' => $contents,
        ]);
    }
}
