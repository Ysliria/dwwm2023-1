<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('home/index.html.twig' ,[
            'formations' => $formationRepository->findNextTraining()
        ]);
    }

    #[Route('/contact', name: 'home_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }

    #[Route('/about', name: 'home_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }
}
