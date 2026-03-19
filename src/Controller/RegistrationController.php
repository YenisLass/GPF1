<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em,
        Security $security
    ): Response {
        $membre = new Membre();
        $form = $this->createForm(RegistrationFormType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membre->setPassword(
                $passwordHasher->hashPassword($membre, $form->get('plainPassword')->getData())
            );
            $membre->setRoles(['ROLE_USER']);

            $em->persist($membre);
            $em->flush();

            // Connexion automatique après inscription
            return $security->login($membre, \App\Security\LoginFormAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}