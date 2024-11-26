<?php

namespace App\Controller;

use App\Entity\Tache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TacheController extends AbstractController
{
    #[Route('/tache', name: 'app_tache')]
    public function index(EntityManagerInterface $em): Response
    {

        // récupérer une liste de tâche
        $listeTache = $em->getRepository(Tache::class)->findAll();
        dump($listeTache);

        // $taches = $em->getRepository(Tache::class)->findAll();


        return $this->render('tache/index.html.twig', [
            'listeTache' => $listeTache,
        ]);
    }
}
