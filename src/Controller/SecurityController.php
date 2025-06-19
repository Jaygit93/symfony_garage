<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    #[Route("/login", name: "app_login")]
    public function login(
        AuthenticationUtils $authenticationUtils, 
        EntityManagerInterface $entityManager, 
        SessionInterface $session
    ): Response {
        // Si l'utilisateur est déjà connecté, rediriger
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        // Récupérer l'ID du dernier utilisateur inscrit depuis la session
        $lastUserId = $session->get('last_registered_user_id');
        if ($lastUserId) {
            $utilisateur = $entityManager->getRepository(User::class)->find($lastUserId);

            if ($utilisateur) {
                $dateInscription = (new \DateTime('+1 hour'))->format('d/m/Y à H:i:s');
                dump([
                    'message' => 'Informations de l\'utilisateur inscrit',
                    'id' => $utilisateur->getId(),
                    'nom' => $utilisateur->getNomUtilisateur(),
                    'prenom' => $utilisateur->getPrenomUtilisateur(),
                    'email' => $utilisateur->getEmailUtilisateur(),
                    'date_inscription' => $dateInscription,
                ]);
            }
            
            // Supprimer la clé de session après le dump
            $session->remove('last_registered_user_id');
        }

        // Récupérer les erreurs de connexion et le nom d'utilisateur
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Récupérer les informations de tentative de connexion depuis la session
        $loginAttempts = $session->get('login_attempts', 0);
        $lastAttemptTime = $session->get('last_attempt_time', 0);
        $lockTime = 300; // Temps de verrouillage en secondes (ex. 5 minutes)

        // Vérifier si l'utilisateur est bloqué
        if ($loginAttempts >= 5 && (time() - $lastAttemptTime) < $lockTime) {
            // Afficher un message flash d'alerte
            $this->addFlash('danger', 'Trop de tentatives échouées. Vous devez attendre quelques minutes avant de réessayer.');
            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
            ]);
        }

        // Si la tentative précédente a échoué, incrémenter le compteur de tentatives
        if ($error) {
            $loginAttempts++;
            $session->set('login_attempts', $loginAttempts);
            $session->set('last_attempt_time', time());
        }

        // Réinitialiser les tentatives de connexion après une connexion réussie
        if (!$error) {
            $session->set('login_attempts', 0);
        }

        // Rendu de la page de connexion
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route("/logout", name: "app_logout")]
    public function logout(): void
    {
        // Le système de sécurité de Symfony gère la déconnexion automatiquement.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}