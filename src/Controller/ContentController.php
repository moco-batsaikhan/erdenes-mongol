<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Content;
use App\Form\CkeditorCreateFormType;
use App\Form\CkeditorEditFormType;
use App\Form\ContentPdfCreateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\type;

#[Route('/content', name: 'app_content')]
class ContentController extends AbstractController
{

    private $current = 'content';
    private $pageTitle = 'Контент';
    private $columnSearch = [];


    #[Route('/pdf', name: '_pdf_index')]
    public function pdfIndex(EntityManagerInterface $em): Response
    {

        $contentRepo = $em->getRepository(Content::class);
        $content = $contentRepo->findBy(['type' => 'PDF']);

        return $this->render('content_pdf/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
            'contents' => $content,
        ]);
    }

    #[Route('/ckeditor', name: '_ckeditor_index')]
    public function ckeditorIndex(EntityManagerInterface $em): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $content = $contentEditorRepo->findBy(['type' => 'CK_EDITOR']);

        return $this->render('content_ckeditor/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
            'contents' => $content,
        ]);
    }


    #[Route('/create/pdf', name: '_create_pdf')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $contentPdf = new Content;
        $contentPdf->setType('PDF');
        $contentPdfForm = $this->createForm(ContentPdfCreateFormType::class, $contentPdf);

        $contentPdfForm->handleRequest($request);

        if ($contentPdfForm->isSubmitted() && $contentPdfForm->isValid()) {
            try {
                $em->persist($contentPdf);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($contentPdf->getId());
                $log->setAction('Шинэ pdf үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_content_create_pdf');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_pdf_index');
        }

        return $this->render('content_pdf/create.html.twig', [
            'contentPdfForm' => $contentPdfForm->createView(),
            'page_title' => 'Үндсэн цэс',
        ]);
    }


    // #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    // public function editCkEditor($id, EntityManagerInterface $em, Request $request): Response
    // {
    //     $content = $em->getRepository(Content::class)->find($id);
    //     $data = $content->findOneById($id)['body'];

    //     $contentForm = $this->createForm(CkeditorEditFormType::class, $content, [
    //         'method' => 'POST',
    //     ]);

    //     $contentForm->handleRequest($request);

    //     if ($contentForm->isSubmitted() && $contentForm->isValid()) {

    //         $em->persist($content);
    //         $em->flush();

    //         $log = new CmsAdminLog();
    //         $log->setAdminname($this->getUser());
    //         $log->setIpaddress($request->getClientIp());
    //         $log->setValue($content->getName());
    //         $log->setAction('мэдээлэл засав.');
    //         $log->setCreatedAt(new \DateTime('now'));

    //         $em->persist($log);
    //         $em->flush();

    //         $this->addFlash('success', 'Амжилттай засагдлаа.');
    //         return $this->redirectToRoute('app_content_ckeditor_edit', array('id' => $id));
    //     }


    //     return $this->render('content_ckeditor/edit.html.twig', [
    //         'contentForm' => $contentForm->createView(),
    //         'data' => $data,
    //         'page_title' => 'мэдээлэл засах',
    //     ]);
    // }


    #[Route('/ckeditor/create', name: '_create_ckeditor')]
    public function createCkeditor(EntityManagerInterface $em, Request $request): Response
    {
        $content = new Content();
        $content->setType('CK_EDITOR');
        $contentForm = $this->createForm(CkeditorCreateFormType::class, $content, [
            'method' => 'POST',
        ]);

        $contentForm->handleRequest($request);

        if ($contentForm->isSubmitted() && $contentForm->isValid()) {

            $em->persist($content);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($content->getId());
            $log->setAction('Шинэ мэдээлэл үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_ckeditor_index');
        }

        return $this->render('content_ckeditor/create.html.twig', [
            'form' => $contentForm->createView(),
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Нэмэх',
        ]);
    }
}
