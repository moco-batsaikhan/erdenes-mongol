<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\VideoNews;
use App\Form\VideoEditFormType;
use App\Form\VideoNewsCreateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/video/news', name: 'app_video_news')]
class VideoNewsController extends AbstractController
{

    private $current = 'videoNews';
    private $pageTitle = 'Видео мэдээлэл';


    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {

        $videoNewsRepo = $em->getRepository(VideoNews::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $videoNews = $videoNewsRepo->findAll();
        $data = $videoNewsRepo->findBy([], ['id' => 'DESC'], $pageSize, $offset);


        return $this->render('video_news/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Видео мэдээлэл',
            'videos' => $data,
            'pageCount' => ceil(count($videoNews) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_video_news_index'
        ]);
    }

    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $videoNews = new VideoNews;
        $videoNewsForm = $this->createForm(VideoNewsCreateFormType::class, $videoNews);

        $videoNewsForm->handleRequest($request);

        if ($videoNewsForm->isSubmitted() && $videoNewsForm->isValid()) {
            try {

                $em->persist($videoNews);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($videoNews->getName());
                $log->setAction('Шинэ нүүр зураг үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_video_news_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_video_news_index');
        }

        return $this->render('video_news/create.html.twig', [
            'videoNewsForm' => $videoNewsForm->createView(),
            'page_title' => 'Видео мэдээлэл',
        ]);
    }


    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $videoNews = $em->getRepository(VideoNews::class)->find($id);

        $editVideoForm = $this->createForm(VideoEditFormType::class, $videoNews, [
            'method' => 'POST',
        ]);

        $editVideoForm->handleRequest($request);

        if ($editVideoForm->isSubmitted() && $editVideoForm->isValid()) {

            $em->persist($videoNews);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($videoNews->getId());
            $log->setAction('Нүүр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_video_news_index', array('id' => $id));
        }


        return $this->render('video_news/edit.html.twig', [
            'editVideoForm' => $editVideoForm->createView(),
            'page_title' => 'Нүүр зураг засах',
        ]);
    }
}
