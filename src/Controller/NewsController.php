<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
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
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $news = new News;
        $newsForm = $this->createForm(NewsCreateFormType::class, $news);

        $newsForm->handleRequest($request);

        if ($newsForm->isSubmitted() && $newsForm->isValid()) {
            try {

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
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_news_create');
                }
            }
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
}
