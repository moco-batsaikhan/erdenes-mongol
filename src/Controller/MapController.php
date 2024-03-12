<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Map;
use App\Entity\MapType;
use App\Form\MapCreateFormType;
use App\Form\MapEditFormType;
use App\Form\MapTypeCreateType;
use App\Form\MapTypeEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/map', name: 'app_map')]
class MapController extends AbstractController
{
    private $current = 'map';
    private $pageTitle = 'Төсөл хөтөлбөрүүд';
    private $columnSearch = [];

    #[Route('/{page}', name: '_index', requirements: ['page' => "\d+"])]
    public function index(EntityManagerInterface $em, $page = 1): Response
    {

        $mapRepo = $em->getRepository(Map::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $map = $mapRepo->findAll();
        $data = $mapRepo->findBy([],  ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('map/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Төсөл хөтөлбөр',
            'mapDatas' => $data,
            'pageCount' => ceil(count($map) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_map_index'
        ]);
    }

    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {

        $map = new Map;
        $mapForm = $this->createForm(MapCreateFormType::class, $map);

        $mapForm->handleRequest($request);

        if ($mapForm->isSubmitted() && $mapForm->isValid()) {
            try {
                $errors = $validator->validate($map);
              
              
                if (count($errors) > 0) {
    
                    $errorsString =  $errors[0]->getMessage();
            
                    $this->addFlash('danger', $errorsString);
                    return $this->redirectToRoute('app_map_create');
                }
    
                $map->setCreatedUser($this->getUser());
                $em->persist($map);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($map->getMnName());
                $log->setAction('Шинэ төсөл хөтөлбөр үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_map_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_map_index');
        }

        return $this->render('map/create.html.twig', [
            'mapForm' => $mapForm->createView(),
            'page_title' => 'Төсөл хөтөлбөр',
        ]);
    }

    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {
        $map = $em->getRepository(Map::class)->find($id);

        $editMapForm = $this->createForm(MapEditFormType::class, $map, [
            'method' => 'POST',
        ]);

        $editMapForm->handleRequest($request);

        if ($editMapForm->isSubmitted() && $editMapForm->isValid()) {

            $errors = $validator->validate($map);
              
              
            if (count($errors) > 0) {

                $errorsString =  $errors[0]->getMessage();
        
                $this->addFlash('danger', $errorsString);
                return $this->redirectToRoute('app_map_edit');
            }
            $em->persist($map);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($map->getMnName());
            $log->setAction('Төсөл хөтөлбөр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_map_index', array('id' => $id));
        }


        return $this->render('map/edit.html.twig', [
            'mapForm' => $editMapForm->createView(),
            'page_title' => 'Төсөл хөтөлбөр засах',
        ]);
    }

    #[Route('/type/{page}', name: '_type_index', requirements: ['page' => "\d+"])]
    public function typeIndex(EntityManagerInterface $em, $page = 1): Response
    {

        $mapRepo = $em->getRepository(MapType::class);
        $pageSize = 30;
        $offset = ($page - 1) * $pageSize;
        $map = $mapRepo->findAll();
        $data = $mapRepo->findBy([],  ["createdAt"=>"DESC"], $pageSize, $offset);


        return $this->render('map_type/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Төсөл хөтөлбөр',
            'mapTypes' => $data,
            'pageCount' => ceil(count($map) / $pageSize),
            'currentPage' => $page,
            'pageRoute' => 'app_map_index'
        ]);
    }

    #[Route('/type/create', name: '_type_create')]
    public function typeCreate(EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {

        $mapType = new MapType;
        $mapTypeForm = $this->createForm(MapTypeCreateType::class, $mapType);

        $mapTypeForm->handleRequest($request);

        if ($mapTypeForm->isSubmitted() && $mapTypeForm->isValid()) {
    
                $em->persist($mapType);
                $em->flush();

                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUserIdentifier());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($mapType->getMnName());
                $log->setAction('Шинэ төсөл хөтөлбөр үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
                $em->flush();
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_map_type_index');
        }

        return $this->render('map_type/create.html.twig', [
            'mapTypeForm' => $mapTypeForm->createView(),
            'page_title' => 'Төсөл хөтөлбөр',
        ]);
    }

    #[Route('/type/edit/{id}', name: '_type_edit', requirements: ['id' => "\d+"])]
    public function typeEdit($id, EntityManagerInterface $em, Request $request,ValidatorInterface $validator): Response
    {
        $mapType = $em->getRepository(MapType::class)->find($id);

        $editMapTypeForm = $this->createForm(MapTypeEditType::class, $mapType, [
            'method' => 'POST',
        ]);

        $editMapTypeForm->handleRequest($request);

        if ($editMapTypeForm->isSubmitted() && $editMapTypeForm->isValid()) {


            $em->persist($mapType);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser()->getUserIdentifier());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($mapType->getMnName());
            $log->setAction('Төсөл хөтөлбөр мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();

            $this->addFlash('success', 'Амжилттай засагдлаа.');
            return $this->redirectToRoute('app_map_type_index', array('id' => $id));
        }


        return $this->render('map_type/edit.html.twig', [
            'mapTypeForm' => $editMapTypeForm->createView(),
            'page_title' => 'Төсөл хөтөлбөр засах',
        ]);
    }
}
