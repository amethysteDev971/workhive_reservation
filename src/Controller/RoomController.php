<?php

namespace App\Controller;

use App\Entity\Room;
use App\Enum\Status;
use App\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;

class RoomController extends AbstractController
{
    #[Route('admin/room', name: 'app_room')]
    public function index(EntityManagerInterface $em,Request $request): Response
    {
        $rooms = $em->getRepository(Room::class)->findAll();

        return $this->render('admin/room/index.html.twig', [
            'controller_name' => 'RoomController',
            'rooms' => $rooms,
        ]);
    }

    #[Route('admin/room/create', name: 'app_room_create')]
    public function createRoom(EntityManagerInterface $em,Request $request): Response
    {
        // creates a room object and initializes some data for this example
        $room = new Room();
        // $room ->setName("Salle Amethyste");
        // $room->setCapacity(10);
        // $room->setWidth(5.78);
        // $room->setLength(6.3);
        // $room->setStatus(Status::ACTIVE);

        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $room = $form->getData();
            $em->persist($room);
            $em->flush();

            return $this->redirectToRoute('app_room');
        }

        return $this->render('admin/room/create_room.html.twig', [
            'controller_name' => 'RoomController Create',
            'form' => $form,
        ]);
    }


    #[Route('admin/room/update/{id}', name: 'app_room_update')]
    public function updateRoom(EntityManagerInterface $em,Request $request, $id): Response
    {

        dump($id);
        $room = $em->getRepository(Room::class)->find($id);
        $form = $this->createForm(RoomType::class, $room);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $room = $form->getData();
            $em->persist($room);
            $em->flush();

            return $this->redirectToRoute('app_room');
        }

        return $this->render('admin/room/create_room.html.twig', [
            'controller_name' => 'RoomController Create',
            'form' => $form,
        ]);
    }

    #[Route('admin/room/delete/{id}', name: 'app_room_delete')]
    public function deleteRoom(EntityManagerInterface $em,Request $request, $id): Response
    {
        $room = $em->getRepository(Room::class)->find($id);
        $em->remove($room);
        $em->flush();


        return $this->redirectToRoute('app_room');
        return $this->render('admin/room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
}
