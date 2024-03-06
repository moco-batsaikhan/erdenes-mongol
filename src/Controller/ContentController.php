<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Content;
use App\Form\ChartDataCreateFormType;
use App\Form\ChartDataEditFormType;
use App\Form\CkeditorCreateFormType;
use App\Form\CkeditorEditFormType;
use App\Form\ContentPdfCreateFormType;
use App\Form\ContentPdfEditFormType;
use App\Form\HomeChartCreateFormType;
use App\Form\HomeChartEditFormType;
use App\Form\SlideCreateFormType;
use App\Form\SlideEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/content', name: 'app_content')]
class ContentController extends AbstractController
{

    private $current = 'content';
    private $pageTitle = 'Контент';
    private $columnSearch = [];
    private $pathName = '';


    #[Route('/ckeditor/{page}', name: '_ckeditor_index', requirements: ['page' => "\d+"])]
    public function ckeditorIndex(EntityManagerInterface $em, $page = 1): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $content = $contentEditorRepo->findBy(['type' => 'CK_EDITOR']);
        $data = $contentEditorRepo->findBy(['type' => 'CK_EDITOR'], ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('content_ckeditor/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ HTML',
            'contents' => $data,
            'pageCount' => ceil(count($content) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_content_ckeditor_index'
        ]);
    }

    #[Route('/ckeditor/edit/{id}', name: '_edit_ckeditor', requirements: ['id' => "\d+"])]
    public function editCkEditor($id, EntityManagerInterface $em, Request $request): Response
    {
        $content = $em->getRepository(Content::class)->find($id);

        $contentForm = $this->createForm(CkeditorEditFormType::class, $content, [
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
            $log->setAction('Мэдээ HTML засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_content_ckeditor_index', array('id' => $id));
        }


        return $this->render('content_ckeditor/edit.html.twig', [
            'form' => $contentForm->createView(),
            'page_title' => 'Мэдээ HTML засах',
        ]);
    }


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
            $log->setAction('Мэдээ HTML үүсгэв.');
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






    #[Route('/pdf/{page}', name: '_pdf_index', requirements: ['page' => "\d+"])]
    public function pdfIndex(EntityManagerInterface $em, $page = 1): Response
    {
        $contentRepo = $em->getRepository(Content::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $content = $contentRepo->findBy(['type' => 'PDF']);
        $data = $contentRepo->findBy(['type' => 'PDF'],  ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('content_pdf/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
            'contents' => $data,
            'pageCount' => ceil(count($content) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_content_pdf_index'
        ]);
    }

    #[Route('/create/pdf', name: '_create_pdf')]
    public function createPdf(EntityManagerInterface $em, Request $request): Response
    {

        $contentPdf = new Content;
        $contentPdf->setType('PDF');
        $contentPdfForm = $this->createForm(ContentPdfCreateFormType::class, $contentPdf);

        $contentPdfForm->handleRequest($request);

        if ($contentPdfForm->isSubmitted() && $contentPdfForm->isValid()) {
            $em->persist($contentPdf);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($contentPdf->getId());
            $log->setAction('Шинэ Мэдээ PDF үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_pdf_index');
        }

        return $this->render('content_pdf/create.html.twig', [
            'contentPdfForm' => $contentPdfForm->createView(),
            'page_title' => 'Мэдээ PDF',
        ]);
    }

    #[Route('/edit/{id}', name: '_pdf_edit', requirements: ['id' => "\d+"])]
    public function editPdf($id, EntityManagerInterface $em, Request $request): Response
    {
        $pdf = $em->getRepository(Content::class)->find($id);

        $editPdfForm = $this->createForm(ContentPdfEditFormType::class, $pdf, [
            'method' => 'POST',
        ]);

        $editPdfForm->handleRequest($request);

        if ($editPdfForm->isSubmitted() && $editPdfForm->isValid()) {

            $em->persist($pdf);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($pdf->getId());
            $log->setAction('Мэдээ PDF засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_content_pdf_index', array('id' => $id));
        }


        return $this->render('content_pdf/edit.html.twig', [
            'contentPdfForm' => $editPdfForm->createView(),
            'page_title' => 'Мэдээ PDF засах',
        ]);
    }












    private function extractJsonFromExcel(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet): array
    {
        $sheet = $spreadsheet->getActiveSheet();
        $jsonColumn = $sheet->getColumnIterator()->current();

        $jsonArray = [];

        foreach ($jsonColumn->getCellIterator() as $cell) {
            $jsonArray[] = json_decode($cell->getValue(), true);
        }

        return $jsonArray;
    }

    #[Route('/chart-list', name: '_chart_list_index')]
    public function listIndex(): Response
    {

        return $this->render('content_chart/chart-list.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
        ]);
    }

    #[Route('/home/graph/list', name: '_home_graph_index')]
    public function HomeListIndex(): Response
    {

        return $this->render('home_chart/chart-list.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => ' График ',
        ]);
    }











    #[Route('/chart/{page}', name: '_chart_index', requirements: ['page' => "\d+"])]
    public function chartIndex(EntityManagerInterface $em, $page = 1): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $content = $contentEditorRepo->findBy(['type' => 'JSON']);
        $data = $contentEditorRepo->findBy(['type' => 'JSON'],  ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('content_chart/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээний график ',
            'contents' => $data,
            'pageCount' => ceil(count($content) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_content_chart_index'
        ]);
    }

    #[Route('/create/chart', name: '_create_chart')]
    public function createChartData(EntityManagerInterface $em, Request $request): Response
    {
        $chartName = $request->get('chartName');

        $contentChart = new Content;
        $contentChart->setType('JSON');
        $contentChart->setGraphType($chartName);
        $contentChartForm = $this->createForm(ChartDataCreateFormType::class, $contentChart);

        $contentChartForm->handleRequest($request);

        if ($contentChartForm->isSubmitted() && $contentChartForm->isValid()) {

            $excelFile = $contentChartForm->get('file')->getData();

            $jsonData = $this->processFile($excelFile);

            $jsonDataArray = json_decode($jsonData, true);

            $contentChart->setFile($jsonDataArray);

            $em->persist($contentChart);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($contentChart->getId());
            $log->setAction('Шинэ Мэдээний график үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_chart_index');
        }

        return $this->render('content_chart/create.html.twig', [
            'contentChartForm' => $contentChartForm->createView(),
            'pathName' => $chartName,
            'page_title' => 'Мэдээний график',
        ]);
    }

    #[Route('/edit/chart/{id}', name: '_edit_chart', requirements: ['id' => "\d+"])]
    public function editChart($id, EntityManagerInterface $em, Request $request): Response
    {
        $config = $em->getRepository(Content::class)->find($id);


        $editChartForm = $this->createForm(ChartDataEditFormType::class, $config, [
            'method' => 'POST',
        ]);

        $editChartForm->handleRequest($request);

        if ($editChartForm->isSubmitted() && $editChartForm->isValid()) {

            $em->persist($config);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($config->getId());
            $log->setAction('Мэдээний график засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай тохирууллаа.');
            return $this->redirectToRoute('app_content_chart_index');
        }

        return $this->render('content_chart/edit.html.twig', [
            'editForm' => $editChartForm->createView(),
            'page_title' => 'Мэдээний график засах',
        ]);
    }















    #[Route('/home-chart/{page}', name: '_chart_home_index', requirements: ['page' => "\d+"])]
    public function chartHomeIndex(EntityManagerInterface $em, $page = 1): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $content = $contentEditorRepo->findBy(['type' => 'HOME_JSON']);
        $data = $contentEditorRepo->findBy(['type' => 'HOME_JSON'], null, $pageSize, $offset);


        return $this->render('home_chart/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'contents' => $data,
            'pageCount' => ceil(count($content) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_content_chart_home_index'
        ]);
    }

    #[Route('/create/home-chart', name: '_create_home_chart')]
    public function createHomeChartData(EntityManagerInterface $em, Request $request): Response
    {
        $chartName = $request->get('chartName');

        $contentChart = new Content;
        $contentChart->setType('HOME_JSON');
        $contentChart->setPriority(1);
        $contentChart->setGraphType($chartName);
        $contentChartForm = $this->createForm(HomeChartCreateFormType::class, $contentChart);

        $contentChartForm->handleRequest($request);

        if ($contentChartForm->isSubmitted() && $contentChartForm->isValid()) {

            $excelFile = $contentChartForm->get('file')->getData();

            $jsonData = $this->processFile($excelFile);

            $jsonDataArray = json_decode($jsonData, true);

            $contentChart->setFile($jsonDataArray);

            $em->persist($contentChart);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($contentChart->getId());
            $log->setAction('Шинээр нүүр хэсгийн график үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_chart_home_index');
        }

        return $this->render('home_chart/create.html.twig', [
            'contentChartForm' => $contentChartForm->createView(),
            'pathName' => $chartName,
            'page_title' => 'Нүүр график',
        ]);
    }

    #[Route('/edit/home-chart/{id}', name: '_edit_home_chart', requirements: ['id' => "\d+"])]
    public function editHomeChart($id, EntityManagerInterface $em, Request $request): Response
    {
        $config = $em->getRepository(Content::class)->find($id);
        

        $editHomeChartForm = $this->createForm(HomeChartEditFormType::class, $config, [
            'method' => 'POST',
        ]);

        $editHomeChartForm->handleRequest($request);

        if ($editHomeChartForm->isSubmitted() && $editHomeChartForm->isValid()) {

            $excelFile = $editHomeChartForm->get('file')->getData();

            $jsonData = $this->processFile($excelFile);

            $jsonDataArray = json_decode($jsonData, true);

            $config->setFile($jsonDataArray);


            $em->persist($config);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($config->getId());
            $log->setAction('Нүүр хэсгийн график засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай тохирууллаа.');
            return $this->redirectToRoute('app_content_chart_home_index');
        }

        return $this->render('home_chart/edit.html.twig', [
            'editForm' => $editHomeChartForm->createView(),
            'page_title' => 'Нүүр график засах',
        ]);
    }













    private function processFile($file)
    {
        if ($file === null || !$file->isValid()) {
            throw new \Exception('Invalid file');
        }

        $fileExtension = $file->getClientOriginalExtension();

        if (!in_array($fileExtension, ['xls', 'xlsx'])) {
            throw new \Exception('Invalid file format. Please upload an Excel file.');
        }

        $spreadsheet = IOFactory::load($file->getPathname());

        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray(null,true,false);

        $headers = array_shift($data);

        $jsonData = [];

        foreach ($data as $row) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                if (isset($row[$index])) {
                    $rowData[$header] = $row[$index];
                } else {
                    $rowData[$header] = '';
                }
            }
            $jsonData[] = $rowData;
        }

        return json_encode($jsonData);
    }

    #[Route('/download-example-file', name: '_download_example_file')]
    public function downloadGraphExampleAction(Request $request): BinaryFileResponse
    {

        $chartName = $request->get('chartName');

        $exampleFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/excel/' . $chartName . '.xlsx';

        if (!file_exists($exampleFilePath)) {
            throw $this->createNotFoundException('Example file not found.');
        }

        return $this->file($exampleFilePath);
    }




    #[Route('/edit/priority', name: '_edit_priority', methods: ['POST'])]
    public function reorder(Request $request, EntityManagerInterface $entityManager)
    {
        $orderedIds = $request->request->get('orderedIds', []);
        $orderedIds = array_filter((array) $orderedIds);



        foreach ($orderedIds as $position => $id) {
            $section = $entityManager->getRepository(Content::class)->find($id);

            if ($section instanceof Content) {
                $section->setPriority($position + 1);
            }
        }

        $entityManager->persist($section);
        $entityManager->flush();

        $log = new CmsAdminLog();
        $log->setAdminname($this->getUser()->getUserIdentifier());
        $log->setIpaddress($request->getClientIp());
        $log->setValue('Байршлууд');
        $log->setAction('Мэдээний байршил өөрчлөв.');
        $log->setCreatedAt(new \DateTime('now'));

        $entityManager->persist($log);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }








    #[Route('/slide/{page}', name: '_slide_index', requirements: ['page' => "\d+"])]
    public function slideIndex(EntityManagerInterface $em, $page = 1): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $content = $contentEditorRepo->findBy(['type' => 'SLIDE']);
        $data = $contentEditorRepo->findBy(['type' => 'SLIDE'],  ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('content_slide/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Контент ',
            'contents' => $data,
            'pageCount' => ceil(count($content) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_content_chart_index'
        ]);
    }


    #[Route('/slide/create', name: '_create_slide')]
    public function createSlide(EntityManagerInterface $em, Request $request): Response
    {
        $content = new Content();
        $content->setType('SLIDE');

        $contentForm = $this->createForm(SlideCreateFormType::class, $content, [
            'method' => 'POST',
        ]);

        $contentForm->handleRequest($request);

        if ($contentForm->isSubmitted() && $contentForm->isValid()) {
            $uploadedFiles = $contentForm['file']->getData();
            $imageFileNames = [];

            foreach ($uploadedFiles as $file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();



                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/image/',
                    $fileName
                );

                $fullFileName = $this->getParameter('base_url') . '/uploads/image/' . $fileName;

                $imageFileNames[] = $fullFileName;
            }

            $content->setFile($imageFileNames);
            $em->persist($content);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($content->getId());
            $log->setAction('Шинэ Мэдээ SLIDE үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_slide_index');
        }

        return $this->render('content_slide/create.html.twig', [
            'form' => $contentForm->createView(),
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Мэдээ SLIDE',
        ]);
    }

    #[Route('/slide/edit/{id}', name: '_edit_slide', requirements: ['id' => "\d+"])]
    public function editSlide($id, EntityManagerInterface $em, Request $request): Response
    {
        $config = $em->getRepository(Content::class)->find($id);

        $editSlideForm = $this->createForm(SlideEditFormType::class, $config, [
            'method' => 'POST',
        ]);

        $editSlideForm->handleRequest($request);

        if ($editSlideForm->isSubmitted() && $editSlideForm->isValid()) {

            $em->persist($config);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($config->getId());
            $log->setAction('Мэдээ SLIDE засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай тохирууллаа.');
            return $this->redirectToRoute('app_content_slide_index');
        }

        return $this->render('content_slide/edit.html.twig', [
            'form' => $editSlideForm->createView(),
            'page_title' => 'Мэдээ SLIDE',
        ]);
    }
}
