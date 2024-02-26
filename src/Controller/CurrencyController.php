<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Currency;
use App\Form\CurrencyCreateFormType;
use App\Form\CurrencyEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;



#[Route('/currency', name: 'app_currency')]
class CurrencyController extends AbstractController
{
    private $current = 'currency';
    private $pageTitle = 'Ханшийн мэдээлэл';

    #[Route('/download-example-file', name: '_download_example_file')]
    public function downloadExampleAction(Request $request): BinaryFileResponse
    {

        $exampleFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/excel/currency.xlsx';

        if (!file_exists($exampleFilePath)) {
            throw $this->createNotFoundException('Example file not found.');
        }

        return $this->file($exampleFilePath);
    }

    #[Route('/download-example-file-second', name: '_download_example_file_second')]
    public function downloadFileExampleAction(Request $request): BinaryFileResponse
    {

        $exampleFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/excel/currency-en.xlsx';

        if (!file_exists($exampleFilePath)) {
            throw $this->createNotFoundException('Example file not found.');
        }

        return $this->file($exampleFilePath);
    }

    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {

        $currencyRepo = $em->getRepository(Currency::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $currency = $currencyRepo->findAll();
        $data = $currencyRepo->findBy([], null, $pageSize, $offset);


        return $this->render('currency/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Админ',
            'items' => $data,
            'pageCount' => ceil(count($currency) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_currency_index'
        ]);
    }


    #[Route('/create', name: '_create')]
    public function createHomeChartData(EntityManagerInterface $em, Request $request): Response
    {

        $currency = new Currency;
        $currencyForm = $this->createForm(CurrencyCreateFormType::class, $currency);

        $currencyForm->handleRequest($request);

        if ($currencyForm->isSubmitted() && $currencyForm->isValid()) {

            $excelFile = $currencyForm->get('file')->getData();

            $jsonData = $this->processFile($excelFile);

            $jsonDataArray = json_decode($jsonData, true);

            $secondExcelFile = $currencyForm->get('enFile')->getData();

            $secondJsonData = $this->processFile($secondExcelFile);

            $secondJsonDataArray = json_decode($secondJsonData, true);

            $currency->setFile($jsonDataArray);
            $currency->setEnFile($secondJsonDataArray);


            $currency->setCreatedUser($this->getUser());

            $em->persist($currency);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($currency->getId());
            $log->setAction('Шинээр ханшийн мэдээлэл үүсгэв.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_currency_index');
        }

        return $this->render('currency/create.html.twig', [
            'currencyForm' => $currencyForm->createView(),
            'page_title' => 'ханшийн мэдээлэл',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $currency = $em->getRepository(Currency::class)->find($id);

        $editCurrencyForm = $this->createForm(CurrencyEditFormType::class, $currency, [
            'method' => 'POST',
        ]);

        $editCurrencyForm->handleRequest($request);

        if ($editCurrencyForm->isSubmitted() && $editCurrencyForm->isValid()) {

            $excelFile = $editCurrencyForm->get('file')->getData();

            $jsonData = $this->processFile($excelFile);

            $jsonDataArray = json_decode($jsonData, true);

            $secondExcelFile = $editCurrencyForm->get('enFile')->getData();

            $secondJsonData = $this->processFile($secondExcelFile);

            $secondJsonDataArray = json_decode($secondJsonData, true);

            $currency->setFile($jsonDataArray);
            $currency->setEnFile($secondJsonDataArray);

            $em->persist($currency);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($currency->getId());
            $log->setAction('ханшийн мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_currency_index', array('id' => $id));
        }


        return $this->render('currency/edit.html.twig', [
            'currencyForm' => $editCurrencyForm->createView(),
            'page_title' => 'Нүүр зураг засах',
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
        $data = $worksheet->toArray();

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
}
