<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $passwordHasher,
        SessionInterface $session
    ): Response {
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $motDePasse = $request->request->get('motDePasse');

            // Créer un nouvel utilisateur
            $utilisateur = new User();
            $utilisateur->setNomUtilisateur($nom);
            $utilisateur->setPrenomUtilisateur($prenom);
            $utilisateur->setEmailUtilisateur($email);

            // Encoder le mot de passe
            $encodedPassword = $passwordHasher->hashPassword($utilisateur, $motDePasse);
            $utilisateur->setPassword($encodedPassword);

            // Définir le rôle
            $utilisateur->setRoleUtilisateur('client');

            // Sauvegarder l'utilisateur en base
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Stocker l'ID de l'utilisateur dans la session
            $session->set('last_registered_user_id', $utilisateur->getId());

            // Ajouter un message flash avec l'heure corrigée
            $timestampFlash = (new \DateTime('+1 hour'))->format('d/m/Y à H:i:s');
            $this->addFlash('success', sprintf(
                "Inscription réussie pour %s %s le %s. Vous pouvez à présent vous connecter",
                $prenom,
                $nom,
                $timestampFlash
            ));

            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Afficher le formulaire
        return $this->render('security/inscription.html.twig');
    }
}