<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Currency;
use App\Form\CurrencyCreateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/currency', name: 'app_currency')]
class CurrencyController extends AbstractController
{
    private $current = 'currency';
    private $pageTitle = 'Ханшийн мэдээлэл';

    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $currencyRepo = $em->getRepository(Currency::class);
        $currency = $currencyRepo->findAll();

        return $this->render('currency/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Админ',
            'currencys' => $currency,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $currency = new Currency;
        $currencyForm = $this->createForm(CurrencyCreateFormType::class, $currency);

        $currencyForm->handleRequest($request);

        if ($currencyForm->isSubmitted() && $currencyForm->isValid()) {
            try {

                $em->persist($currency);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($currency->getBase());
                $log->setAction('Шинэ ханшийн мэдээлэл оруулав.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_currency_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_currency_index');
        }

        return $this->render('currency/create.html.twig', [
            'currencyForm' => $currencyForm->createView(),
            'page_title' => 'Нүүр зураг',
        ]);
    }
}
