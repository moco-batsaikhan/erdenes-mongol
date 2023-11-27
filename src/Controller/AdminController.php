<?php

namespace App\Controller;

use App\Entity\CmsAdminLog;
use App\Form\AdminCreateFormType;
use App\Form\AdminEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CmsUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin', name: 'app_admin')]

class AdminController extends AbstractController
{
    private $current = 'admin';
    private $pageTitle = 'Админ удирдлага';

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
                        $registerUserForm->get('password')->getData()
                    )
                );
                $em->persist($user);
                $em->flush();


                $log = new CmsAdminLog();
                $log->setAdminname($this->getUser()->getUsername());
                $log->setIpaddress($request->getClientIp());
                $log->setValue($user->getUsername());
                $log->setAction('Шинэ админ үүсгэв.');
                $log->setCreatedAt(new \DateTime('now'));

                $em->persist($log);
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

        return $this->render('admin/create.html.twig', [
            'adminForm' => $registerUserForm->createView(),
            'page_title' => 'Админ',
        ]);
    }

    #[Route('/admin/edit/{id}', name: '_edit', requirements: ['id' => "\d+"])]
    public function edit($id, EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $em->getRepository(CmsUser::class)->find($id);

        $editUserForm = $this->createForm(AdminEditFormType::class, $user, [
            'method' => 'POST',
        ]);

        $editUserForm->handleRequest($request);

        if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {


            if ($editUserForm->get('password')->getData()) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $editUserForm->get('password')->getData()
                    )
                );
            }
            $em->persist($user);
            $em->flush();

            $log = new CmsAdminLog();
            $log->setAdminname($this->getUser());
            $log->setIpaddress($request->getClientIp());
            $log->setValue($user->getUsername());
            $log->setAction('Админ мэдээлэл засав.');
            $log->setCreatedAt(new \DateTime('now'));

            $em->persist($log);
            $em->flush();


            $this->addFlash('success', 'Амжилттай засагдлаа.');

            return $this->redirectToRoute('app_admin_edit', array('id' => $id));
        }


        return $this->render('admin/edit.html.twig', [
            'adminForm' => $editUserForm->createView(),
            'page_title' => 'Админ засах',
        ]);
    }
}
