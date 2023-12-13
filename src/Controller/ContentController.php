<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Content;
use App\Form\ChartDataCreateFormType;
use App\Form\CkeditorCreateFormType;
use App\Form\CkeditorEditFormType;
use App\Form\ContentPdfCreateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use function PHPSTORM_META\type;

#[Route('/content', name: 'app_content')]
class ContentController extends AbstractController
{

    private $current = 'content';
    private $pageTitle = 'Контент';
    private $columnSearch = [];
    private $pathName = '';

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

    #[Route('/chart', name: '_chart_index')]
    public function chartIndex(EntityManagerInterface $em): Response
    {
        $contentEditorRepo = $em->getRepository(Content::class);
        $content = $contentEditorRepo->findBy(['type' => 'JSON']);

        return $this->render('content_chart/index.html.twig', [
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

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_pdf_index');
        }

        return $this->render('content_pdf/create.html.twig', [
            'contentPdfForm' => $contentPdfForm->createView(),
            'page_title' => 'Үндсэн цэс',
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

    #[Route('/create/chart', name: '_create_chart')]
    public function createChartData(EntityManagerInterface $em, Request $request): Response
    {
        $chartName = $request->get('chartName');

        $contentChart = new Content;
        $contentChart->setType('JSON');
        $contentChartForm = $this->createForm(ChartDataCreateFormType::class, $contentChart);

        $contentChartForm->handleRequest($request);

        if ($contentChartForm->isSubmitted() && $contentChartForm->isValid()) {

            $excelFile = $contentChartForm->get('file')->getData();

            $spreadsheet = IOFactory::load($excelFile->getPathname());
            $json = $this->extractJsonFromExcel($spreadsheet);

            $contentChart->setFile($json);

            $em->persist($contentChart);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($contentChart->getId());
            $log->setAction('Шинэ chart үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_content_chart_index');
        }

        return $this->render('content_chart/create.html.twig', [
            'contentChartForm' => $contentChartForm->createView(),
            'pathName' => $chartName,
            'page_title' => 'Үндсэн цэс',
        ]);
    }

    #[Route('/download-example-file', name: '_download_example_file')]
    public function downloadExampleAction(Request $request)
    {

        $chartName = $request->get('chartName');

        // if ($chartName == 'LineGraph') {
        //     $pathName = 'LineGraph';
        // } elseif ($chartName == 'OrganizationGraph') {
        //     $pathName = 'OrganizationGraph';
        // } elseif ($chartName == 'FlowAnalysisGraph') {
        //     $pathName = 'FlowAnalysisGraph';
        // } elseif ($chartName == 'ColumnGraph') {
        //     $pathName = 'ColumnGraph';
        // } elseif ($chartName == 'DonutGraph') {
        //     $pathName = 'DonutGraph';
        // } elseif ($chartName == 'ComboGraph') {
        //     $pathName = 'ComboGraph';
        // } elseif ($chartName == 'CaugeGraph') {
        //     $pathName = 'LineCaugeGraphGraph';
        // };


        $exampleFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/excel/' . $chartName . '.xlsx';

        if (!file_exists($exampleFilePath)) {
            throw $this->createNotFoundException('Example file not found.');
        }

        $response = new BinaryFileResponse($exampleFilePath);

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'example.xlsx'
        ));

        return $response;
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
}
