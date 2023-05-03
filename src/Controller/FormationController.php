<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formation', name: 'formation_')]
class FormationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'], priority: 2)]
    public function new(Request $request, FormationRepository $formationRepository): Response
    {
        $formation    = new Formation();
        $formationAdd = $this->createForm(FormationType::class, $formation);

        $formationAdd->handleRequest($request);

        if ($formationAdd->isSubmitted() && $formationAdd->isValid()) {
            $formationRepository->save($formation, true);
            $this->addFlash('success', 'La formation " ' . $formation->getNom() . ' " a bien été créée');

            return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/new.html.twig', [
            'formation_add' => $formationAdd->createView()
        ]);
    }

    #[Route('/{id}/update', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, Formation $formation, FormationRepository $formationRepository): Response
    {
        $formationUpdate = $this->createForm(FormationType::class, $formation);

        $formationUpdate->handleRequest($request);

        if ($formationUpdate->isSubmitted() && $formationUpdate->isValid()) {
            $formationRepository->save($formation, true);
            $this->addFlash('success', 'La formation " ' . $formation->getNom() . ' " a bien été mise à jour');

            return $this->redirectToRoute('formation_show', ['id' => $formation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/update.html.twig', [
            'formation_update' => $formationUpdate->createView()
        ]);
    }
}
