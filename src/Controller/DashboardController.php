<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RoomRepository;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    public function index(RoomRepository $repository): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
