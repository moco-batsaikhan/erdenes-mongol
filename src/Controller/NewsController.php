<?php

namespace App\Controller;

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
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/news', name: 'app_news')]
class NewsController extends AbstractController
{

    private $current = 'news';
    private $pageTitle = 'Мэдээ';


    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(Request $request, EntityManagerInterface $em, $page = 1): Response
    {

        $newsRepo = $em->getRepository(News::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $searchTerm = $request->query->get('search');
        $searchDate = $request->query->get('date');

        // $news = $newsRepo->findAll();
        // $data = $newsRepo->findBy([], null, $pageSize, $offset);

        $queryBuilder = $newsRepo->createQueryBuilder('n');
        if ($searchTerm) {
            $queryBuilder->where('n.mnTitle LIKE :searchTerm')
                ->orWhere('n.enTitle LIKE :searchTerm')
                ->orWhere('n.cnTitle LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        if ($searchDate) {
            $queryBuilder->andWhere('n.createdAt = :searchDate')
                ->setParameter('searchDate', $searchDate);
        }

        $data = $queryBuilder->orderBy("n.createdAt", "DESC")->setMaxResults($pageSize)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        $totalCount = $newsRepo->count([]);
        $pageCount = ceil($totalCount / $pageSize);


        return $this->render('news/index.html.twig', [
            'current' => $this->current,
            'frontBaseUrl' => $this->getParameter('front_url'),
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ',
            'news' => $data,
            'pageCount' => $pageCount,
            'currentPage' => $page,
            'pageRoute' => 'app_news_index',
            'searchTerm' => $searchTerm,
            'searchDate'=> $searchDate
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {

        $news = new News;
        $newsForm = $this->createForm(NewsCreateFormType::class, $news);

        $newsForm->handleRequest($request);

        if ($newsForm->isSubmitted() && $newsForm->isValid()) {
            $news->setCreatedUser($this->getUser());

            $errors = $validator->validate($news);
              
              
            if (count($errors) > 0) {

                $errorsString =  $errors[0]->getMessage();
        
                $this->addFlash('danger', $errorsString);
                return $this->redirectToRoute('app_news_create');
            }

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
    public function edit($id, EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $editNewsForm = $this->createForm(NewsEditFormType::class, $news, [
            'method' => 'POST',
        ]);

        $editNewsForm->handleRequest($request);

        if ($editNewsForm->isSubmitted() && $editNewsForm->isValid()) {



            $errors = $validator->validate($news);
              
              
            if (count($errors) > 0) {

                $errorsString =  $errors[0]->getMessage();
        
                $this->addFlash('danger', $errorsString);
                return $this->redirectToRoute('app_news_edit',['id'=>$id]);
            }
            $em->persist($news);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($news->getId());
            $log->setAction('мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_news_index', array('id' => $id));
        }


        return $this->render('news/edit.html.twig', [
            'newsForm' => $editNewsForm->createView(),
            'page_title' => 'Мэдээ засах',
        ]);
    }

    #[Route('/choose-content', name: '_choose_content')]
    public function listIndex(Request $request): Response
    {
        $newsId = $request->query->get('newsId');
        return $this->render('news/choose-content.html.twig', [
            'newsId'=>$newsId,
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
        $log->setAdminname($this->getUser()->getUserIdentifier());
        $log->setIpaddress($request->getClientIp());
        $log->setValue($news->getId());
        $log->setAction('Мэдээ нийтлэв.');
        $log->setCreatedAt(new \DateTime('now'));

        $em->persist($log);
        $em->flush();

        $this->addFlash('success', 'Амжилттай нийтлэгдлээ.');
        return $this->redirectToRoute('app_news_index');
    }
    #[Route('/unpunlish/{id}', name: '_unpunlish', requirements: ['id' => "\d+"])]
    public function unpunlish($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $news->setProcessType('CREATED');

        $em->persist($news);
        $em->flush();

        $log = new CmsAdminLog();
        $log->setAdminname($this->getUser()->getUserIdentifier());
        $log->setIpaddress($request->getClientIp());
        $log->setValue($news->getId());
        $log->setAction('Мэдээ нийтлэхээ болив.');
        $log->setCreatedAt(new \DateTime('now'));

        $em->persist($log);
        $em->flush();

        $this->addFlash('success', 'Амжилттай.');
        return $this->redirectToRoute('app_news_index');
    }


    #[Route('/{id}/contents', name: '_contents', requirements: ['id' => "\d+"])]
    public function contents($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $contents = $em->getRepository(Content::class)->findBy(['News' => $news], ['priority' => 'ASC']);


        return $this->render('news/contents.html.twig', [
            'newsId' => $news->getId(),
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ',
            'contents' => $contents,
        ]);
    }

    #[Route('/{id}/news-example', name: '_example', requirements: ['id' => "\d+"])]
    public function exampleNews($id, EntityManagerInterface $em, Request $request): Response
    {
        $news = $em->getRepository(News::class)->find($id);

        $contents = $em->getRepository(Content::class)->findBy(['News' => $news], ['priority' => 'ASC']);

        dd($contents);


        return $this->render('news/web-example.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ',
            'news' => $news,
            'contents' => $contents,
        ]);
    }
}
