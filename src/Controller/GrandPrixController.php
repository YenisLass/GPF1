<?php

namespace App\Controller;

use App\Entity\GrandPrix;
use App\Form\GrandPrixType;
use App\Repository\GrandPrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/grand-prix')]
final class GrandPrixController extends AbstractController
{
    #[Route(name: 'app_grand_prix_index', methods: ['GET'])]
    public function index(GrandPrixRepository $grandPrixRepository): Response
    {
        return $this->render('grand_prix/index.html.twig', [
            'grand_prixes' => $grandPrixRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grand_prix_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grandPrix = new GrandPrix();
        $form = $this->createForm(GrandPrixType::class, $grandPrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grandPrix);
            $entityManager->flush();

            return $this->redirectToRoute('app_grand_prix_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grand_prix/new.html.twig', [
            'grand_prix' => $grandPrix,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grand_prix_show', methods: ['GET'])]
    public function show(GrandPrix $grandPrix): Response
    {
        return $this->render('grand_prix/show.html.twig', [
            'grand_prix' => $grandPrix,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grand_prix_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GrandPrix $grandPrix, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GrandPrixType::class, $grandPrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_grand_prix_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grand_prix/edit.html.twig', [
            'grand_prix' => $grandPrix,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grand_prix_delete', methods: ['POST'])]
    public function delete(Request $request, GrandPrix $grandPrix, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grandPrix->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($grandPrix);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grand_prix_index', [], Response::HTTP_SEE_OTHER);
    }
}
