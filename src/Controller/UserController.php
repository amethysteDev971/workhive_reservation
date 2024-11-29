<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    #[Route('admin/user', name: 'app_user')]
    public function index(EntityManagerInterface $em,Request $request): Response
    {
        $users = $em->getRepository(User::class)->findAll();


        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    
    #[Route('admin/user/create', name: 'app_user_create')]
    public function createUser(EntityManagerInterface $em,Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('admin/user/create_user.html.twig', [
            'controller_name' => 'UserController',
            'form'  =>  $form
            // 'users' => $users,
        ]);

    }

    #[Route('admin/user/update/{id}', name: 'app_user_update')]
    public function updateUser(EntityManagerInterface $em,Request $request, $id): Response
    {

        // dump($id);
        $user = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $room = $form->getData();
            $em->persist($room);
            $em->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('admin/room/create_room.html.twig', [
            'controller_name' => 'RoomController Create',
            'form' => $form,
        ]);
        
    }

    #[Route('admin/user/delete/{id}', name: 'app_user_delete')]
    public function deleteRoom(EntityManagerInterface $em,Request $request, $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();


        return $this->redirectToRoute('app_user');
    }

}
