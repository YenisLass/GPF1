<?php

namespace App\Controller;

use App\Entity\Meteo;
use App\Form\MeteoType;
use App\Repository\MeteoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/meteo')]
final class MeteoController extends AbstractController
{
    #[Route(name: 'app_meteo_index', methods: ['GET'])]
    public function index(MeteoRepository $meteoRepository): Response
    {
        return $this->render('meteo/index.html.twig', [
            'meteos' => $meteoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_meteo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $meteo = new Meteo();
        $form = $this->createForm(MeteoType::class, $meteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($meteo);
            $entityManager->flush();

            return $this->redirectToRoute('app_meteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meteo/new.html.twig', [
            'meteo' => $meteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meteo_show', methods: ['GET'])]
    public function show(Meteo $meteo): Response
    {
        return $this->render('meteo/show.html.twig', [
            'meteo' => $meteo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meteo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meteo $meteo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeteoType::class, $meteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meteo/edit.html.twig', [
            'meteo' => $meteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meteo_delete', methods: ['POST'])]
    public function delete(Request $request, Meteo $meteo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meteo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($meteo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meteo_index', [], Response::HTTP_SEE_OTHER);
    }
}
