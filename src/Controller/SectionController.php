<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Entity\Layout;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/section', name: 'app_section')]
class SectionController extends AbstractController
{

    private $current = 'section';
    private $pageTitle = 'Видео мэдээлэл';

    #[Route('', name: '_index')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {

        $sectionRepo = $em->getRepository(Layout::class);
        $section = $sectionRepo->createQueryBuilder('s')
            ->orderBy('s.priority', 'ASC')
            ->getQuery();

        $results = $section->getResult();

        $log = new CmsAdminLog();
        $log->setAdminname($this->getUser()->getUserIdentifier());
        $log->setIpaddress($request->getClientIp());
        $log->setValue('Байршлууд');
        $log->setAction('Нүүр хуудас байршил өөрчлөв.');
        $log->setCreatedAt(new \DateTime('now'));

        $em->persist($log);
        $em->flush();


        return $this->render('section/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Нүүр хэсгийн дараалал',
            'sections' => $results,
        ]);
    }


    #[Route('/edit', name: 'edit')]
    public function reorder(Request $request, EntityManagerInterface $entityManager)
    {
        $orderedIds = $request->request->get('orderedIds', []);

        $orderedIds = array_filter((array) $orderedIds);

        foreach ($orderedIds as $position => $id) {
            $section = $entityManager->getRepository(Layout::class)->find($id);

            if ($section instanceof Layout) {
                $section->setPriority($position + 1);
            }
        }

        $entityManager->persist($section);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}
