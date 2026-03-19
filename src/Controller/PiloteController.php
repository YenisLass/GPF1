<?php
namespace App\Controller;

use App\Entity\Pilote;
use App\Form\PiloteType;
use App\Repository\PiloteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/pilote')]
final class PiloteController extends AbstractController
{
    #[Route(name: 'app_pilote_index', methods: ['GET'])]
    public function index(PiloteRepository $piloteRepository): Response
    {
        return $this->render('pilote/index.html.twig', [
            'pilotes' => $piloteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pilote_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $pilote = new Pilote();
        $form = $this->createForm(PiloteType::class, $pilote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imgPilote')->getData();

            if ($imageFile) {
                $safeFilename = $slugger->slug($pilote->getNomPilote() . '-' . $pilote->getPrenomPilote());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->getClientOriginalExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_pilotes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }

                $pilote->setImgPilote($newFilename);
            }

            $entityManager->persist($pilote);
            $entityManager->flush();

            return $this->redirectToRoute('app_pilote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pilote/new.html.twig', [
            'pilote' => $pilote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pilote_show', methods: ['GET'])]
    public function show(Pilote $pilote): Response
    {
        return $this->render('pilote/show.html.twig', [
            'pilote' => $pilote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pilote_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pilote $pilote, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PiloteType::class, $pilote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imgPilote')->getData();

            if ($imageFile) {
                $safeFilename = $slugger->slug($pilote->getNomPilote() . '-' . $pilote->getPrenomPilote());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_pilotes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }

                $pilote->setImgPilote($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_pilote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pilote/edit.html.twig', [
            'pilote' => $pilote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pilote_delete', methods: ['POST'])]
    public function delete(Request $request, Pilote $pilote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pilote->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pilote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pilote_index', [], Response::HTTP_SEE_OTHER);
    }
}