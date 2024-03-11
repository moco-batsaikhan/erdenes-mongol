<?php

namespace App\Controller;

use App\Entity\AboutUs;
use App\Entity\CmsAdminLog;
use App\Form\AboutUsEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/about/us', name: 'app_about_us')]
class AboutUsController extends AbstractController
{

    private $current = 'about us';
    private $pageTitle = 'Бидний тухай';

    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em): Response
    {

        $aboutUsRepo = $em->getRepository(AboutUs::class);
        $aboutUs = $aboutUsRepo->findAll();

        return $this->render('about_us/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Бидний тухай',
            'items' => $aboutUs,
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {
        $config = $em->getRepository(AboutUs::class)->find($id);

        $editAboutUsForm = $this->createForm(AboutUsEditFormType::class, $config, [
            'method' => 'POST',
        ]);

        $editAboutUsForm->handleRequest($request);

        if ($editAboutUsForm->isSubmitted() && $editAboutUsForm->isValid()) {

            $errors = $validator->validate($config);
              
              
            if (count($errors) > 0) {

                $errorsString =  $errors[0]->getMessage();
        
                $this->addFlash('danger', $errorsString);
                return $this->redirectToRoute('app_about_us');
            }

            $em->persist($config);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($config->getId());
            $log->setAction('Компаны танилцуулга мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай тохирууллаа.');
            return $this->redirectToRoute('app_about_us_index', array('id' => $id));
        }

        return $this->render('about_us/edit.html.twig', [
            'abouUsForm' => $editAboutUsForm->createView(),
            'page_title' => 'Компаны танилцуулга мэдээлэл засах',
        ]);
    }
}
