<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Strategy;
use App\Form\StrategyCreateFormType;
use App\Form\StrategyEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;



#[Route('/strategy', name: 'app_strategy')]

class StrategyController extends AbstractController
{
    private $current = 'Strategy';
    private $pageTitle = 'Стратеги';

    #[Route('/index', name: '_index')]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {


        $strategyRepo = $em->getRepository(Strategy::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;

        $strategy = $strategyRepo->findAll();
        $data = $strategyRepo->findBy([], null, $pageSize, $offset);

        return $this->render('strategy/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Стратеги',
            'strategys' => $data,
            'pageCount' => ceil(count($strategy) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_strategy_index'
        ]);
    }

    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request, ValidatorInterface $validator): Response
    {

        $strategy = new Strategy;
        $strategyForm = $this->createForm(StrategyCreateFormType::class, $strategy);

        $strategyForm->handleRequest($request);

        if ($strategyForm->isSubmitted() && $strategyForm->isValid()) {
            try {
                $errors = $validator->validate($strategy);

                if (count($errors) > 0) {

                    $errorsString =  $errors[0]->getMessage();

                    $this->addFlash('danger', $errorsString);
                    return $this->redirectToRoute('app_strategy_create');
                }
                $em->persist($strategy);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($strategy->getId());
                $log->setAction('Шинэ Стратеги үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_strategy_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_strategy_index');
        }

        return $this->render('strategy/create.html.twig', [
            'strategyForm' => $strategyForm->createView(),
            'page_title' => 'Стратеги',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {
        $strategy = $em->getRepository(Strategy::class)->find($id);

        $editStrategyForm = $this->createForm(StrategyEditFormType::class, $strategy, [
            'method' => 'POST',
        ]);

        $editStrategyForm->handleRequest($request);

        if ($editStrategyForm->isSubmitted() && $editStrategyForm->isValid()) {

            $errors = $validator->validate($strategy);

            if (count($errors) > 0) {

                $errorsString =  $errors[0]->getMessage();

                $this->addFlash('danger', $errorsString);
                return $this->redirectToRoute('app_strategy_edit',['id'=>$id]);
            }

            $em->persist($strategy);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($strategy->getId());
            $log->setAction('Стратеги засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_strategy_index', array('id' => $id));
        }


        return $this->render('strategy/edit.html.twig', [
            'strategyForm' => $editStrategyForm->createView(),
            'page_title' => 'Стратеги засах',
        ]);
    }
}
