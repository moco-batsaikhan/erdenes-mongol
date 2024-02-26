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
            'page_title' => 'Мэдээний жагсаалт',
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
            $log->setAction('Шинэ Мэдээний жагсаалт үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_news_type_index');
        }

        return $this->render('news_type/create.html.twig', [
            'newsForm' => $newsTypeForm->createView(),
            'page_title' => 'Мэдээний жагсаалт',
        ]);
    }



    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(NewsType::class)->find($id);

        $editNewsForm = $this->createForm(NewsTypeCreateFormType::class, $news, [
            'method' => 'POST',
        ]);

        $editNewsForm->handleRequest($request);

        if ($editNewsForm->isSubmitted() && $editNewsForm->isValid()) {

            $em->persist($news);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($news->getId());
            $log->setAction('Мэдээний жагсаалт засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_news_type_edit', array('id' => $id));
        }


        return $this->render('news_type/edit.html.twig', [
            'newsForm' => $editNewsForm->createView(),
            'page_title' => 'Нүүр зураг засах',
        ]);
    }

}
