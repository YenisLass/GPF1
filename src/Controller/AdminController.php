<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/membres', name: 'app_admin_membres')]
    public function membres(MembreRepository $membreRepository): Response
    {
        return $this->render('admin/membres.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    #[Route('/membres/{id}/toggle-admin', name: 'app_admin_toggle_role', methods: ['POST'])]
    public function toggleAdmin(
        int $id,
        MembreRepository $membreRepository,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $membre = $membreRepository->find($id);

        if (!$membre) {
            throw $this->createNotFoundException();
        }

        // Empêche de se retirer ses propres droits
        if ($membre === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier votre propre rôle.');
            return $this->redirectToRoute('app_admin_membres');
        }

        $roles = $membre->getRoles();
        if (in_array('ROLE_ADMIN', $roles)) {
            $membre->setRoles(['ROLE_USER']);
        } else {
            $membre->setRoles(['ROLE_ADMIN']);
        }

        $em->flush();
        $this->addFlash('success', 'Rôle mis à jour.');

        return $this->redirectToRoute('app_admin_membres');
    }

    #[Route('/membres/{id}/delete', name: 'app_admin_delete_membre', methods: ['POST'])]
    public function deleteMembre(
        int $id,
        MembreRepository $membreRepository,
        EntityManagerInterface $em
    ): Response {
        $membre = $membreRepository->find($id);

        if ($membre && $membre !== $this->getUser()) {
            $em->remove($membre);
            $em->flush();
            $this->addFlash('success', 'Membre supprimé.');
        }

        return $this->redirectToRoute('app_admin_membres');
    }
}