<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Map;
use App\Form\MapCreateFormType;
use App\Form\MapEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        $data = $mapRepo->findBy([], null, $pageSize, $offset);


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
    public function create(EntityManagerInterface $em, Request $request): Response
    {

        $map = new Map;
        $mapForm = $this->createForm(MapCreateFormType::class, $map);

        $mapForm->handleRequest($request);

        if ($mapForm->isSubmitted() && $mapForm->isValid()) {
            try {

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
    public function edit($id, EntityManagerInterface $em, Request $request): Response
    {
        $map = $em->getRepository(Map::class)->find($id);

        $editMapForm = $this->createForm(MapEditFormType::class, $map, [
            'method' => 'POST',
        ]);

        $editMapForm->handleRequest($request);

        if ($editMapForm->isSubmitted() && $editMapForm->isValid()) {

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
}
