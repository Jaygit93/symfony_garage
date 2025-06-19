<?php

namespace App\Controller\Client;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/profile', name: 'app_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Créer et traiter le formulaire
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier le mot de passe actuel avant d'appliquer les modifications
            $currentPassword = $form->get('currentPassword')->getData();
            if ($this->passwordHasher->isPasswordValid($user, $currentPassword)) {
                // Hashage du nouveau mot de passe
                $newPassword = $form->get('plainPassword')->getData();
                if ($newPassword) {
                    $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hashedPassword);
                }

                // Mise à jour des autres champs
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', 'Profil mis à jour avec succès !');
            } else {
                $this->addFlash('error', 'Mot de passe actuel incorrect.');
            }
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/delete', name: 'app_profile_delete')]
    public function deleteAccount(): Response
    {
        $user = $this->getUser();

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_logout');
    }

}
