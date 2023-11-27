<?php

namespace App\Controller;

use App\Form\AdminCreateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityRepository;
use App\Entity\CmsUser;
use App\Form\AdminCreateType;
use App\Form\AdminEditFormType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

#[Route('/admin', name: 'app_admin')]

class AdminController extends AbstractController
{
    private $current = 'admin';
    private $pageTitle = 'Админ удирдлага';
    private $columnSearch = [];

    #[Route('', name: '_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $userRepo = $em->getRepository(CmsUser::class);
        $user = $userRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Админ',
            'admins' => $user,
        ]);
    }


    #[Route('/create', name: '_create')]
    public function create(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $user = new CmsUser;


        $registerUserForm = $this->createForm(AdminCreateFormType::class, $user);

        $registerUserForm->handleRequest($request);

        if ($registerUserForm->isSubmitted() && $registerUserForm->isValid()) {
            try {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $registerUserForm->get('plainPassword')->getData()
                    )
                );
                $em->persist($user);
                $em->flush();


            } catch (\Exception $e) {
                if ($e->getCode() == '1062') {
                    $this->addFlash('danger', 'Email хаяг давхардаж байна.');
                    return $this->redirectToRoute('app_admin_create');
                }
            }
            $this->addFlash('success', 'Амжилттай нэмэгдлээ.');

            return $this->redirectToRoute('app_admin_index');
        }

        $breadcrumb = array(
            array(
                'route' => 'home',
                'name' => 'Нүүр',
                'current' => 0
            ),
            array(
                'route' => 'admin_home',
                'name' => 'Админ',
                'current' => 0
            ),

            array(
                'route' => 'admin_create',
                'name' => 'Нэмэх',
                'current' => 1
            )
        );


        return $this->render('admin/create.html.twig', [
            'adminForm' => $registerUserForm->createView(),
            'current' => $this->current,
            'page_title' => $this->pageTitle,
            'section_title' => 'Админ үүсгэх',
        ]);
    }
}
