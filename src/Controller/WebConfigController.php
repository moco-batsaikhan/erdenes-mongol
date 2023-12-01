<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\WebConfig;
use App\Form\WebConfigEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/web/config', name: 'app_web_config')]


class WebConfigController extends AbstractController
{
    private $current = 'webconfig';
    private $pageTitle = 'Веб тохиргоо';
    private $columnSearch = [];

    #[Route('/index', name: '_index')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $webConfigRepo = $em->getRepository(WebConfig::class);
        $config = $webConfigRepo->findAll();

        return $this->render('web_config/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Баннер',
            'configForms' => $config,
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $config = $em->getRepository(WebConfig::class)->find($id);

        $editWebConfigForm = $this->createForm(WebConfigEditFormType::class, $config, [
            'method' => 'POST',
        ]);

        $editWebConfigForm->handleRequest($request);

        if ($editWebConfigForm->isSubmitted() && $editWebConfigForm->isValid()) {

            $em->persist($config);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($config->getId());
            $log->setAction('Вебийн тохиргооны мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай тохирууллаа.');
            return $this->redirectToRoute('app_web_config_edit', array('id' => $id));
        }

        return $this->render('web_config/edit.html.twig', [
            'configForm' => $editWebConfigForm->createView(),
            'page_title' => 'Вебийн тохиргооны мэдээлэл засах',
        ]);
    }
}
