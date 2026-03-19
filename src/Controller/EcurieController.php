<?php
namespace App\Controller;

use App\Entity\Ecurie;
use App\Form\EcurieType;
use App\Repository\EcurieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/ecurie')]
final class EcurieController extends AbstractController
{
    #[Route(name: 'app_ecurie_index', methods: ['GET'])]
    public function index(EcurieRepository $ecurieRepository): Response
    {
        return $this->render('ecurie/index.html.twig', [
            'ecuries' => $ecurieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ecurie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $ecurie = new Ecurie();
        $form = $this->createForm(EcurieType::class, $ecurie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $safeFilename = $slugger->slug($ecurie->getNomEcurie());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->getClientOriginalExtension();

                try {
                    $logoFile->move(
                        $this->getParameter('logos_ecuries_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload du logo.');
                }

                $ecurie->setLogo($newFilename);
            }

            $entityManager->persist($ecurie);
            $entityManager->flush();

            return $this->redirectToRoute('app_ecurie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecurie/new.html.twig', [
            'ecurie' => $ecurie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecurie_show', methods: ['GET'])]
    public function show(Ecurie $ecurie): Response
    {
        return $this->render('ecurie/show.html.twig', [
            'ecurie' => $ecurie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ecurie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ecurie $ecurie, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(EcurieType::class, $ecurie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $safeFilename = $slugger->slug($ecurie->getNomEcurie());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->guessExtension();

                try {
                    $logoFile->move(
                        $this->getParameter('logos_ecuries_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload du logo.');
                }

                $ecurie->setLogo($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_ecurie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ecurie/edit.html.twig', [
            'ecurie' => $ecurie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ecurie_delete', methods: ['POST'])]
    public function delete(Request $request, Ecurie $ecurie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ecurie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ecurie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ecurie_index', [], Response::HTTP_SEE_OTHER);
    }
}