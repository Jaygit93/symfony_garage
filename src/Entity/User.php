<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: "utilisateurs")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nomUtilisateur;

    #[ORM\Column(type: 'string', length: 100)]
    private $prenomUtilisateur;

    // Utilisation de "emailUtilisateur" en camelCase dans l'entité, mais on spécifie explicitement le nom de la colonne "email_utilisateur".
    #[ORM\Column(name: 'email_utilisateur', type: 'string', length: 180, unique: true)]
    private $emailUtilisateur;

    #[ORM\Column(name: 'mot_de_passe_utilisateur', type: 'string', length:255)]
    private $motDePasseUtilisateur;

    #[ORM\Column(name: 'role_utilisateur', type: 'string', columnDefinition: "ENUM('admin', 'employe', 'client') NOT NULL")]
    private $roleUtilisateur;

    // Récupérer l'identifiant de l'utilisateur
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    // Récupérer l'email de l'utilisateur
    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    // Définir l'email de l'utilisateur
    public function setEmailUtilisateur(string $emailUtilisateur): self
    {
        $this->emailUtilisateur = $emailUtilisateur;

        return $this;
    }

    // Récupérer les rôles
    public function getRoles(): array
    {
        return [$this->roleUtilisateur];
    }

    public function getRoleUtilisateur(): ?string
    {
        return $this->roleUtilisateur;
    }

    public function setRoleUtilisateur(string $roleUtilisateur): self
    {
        $this->roleUtilisateur = $roleUtilisateur;

        return $this;
    }

    // Implémentation de PasswordAuthenticatedUserInterface pour récupérer le mot de passe
    public function getPassword(): string
    {
        return $this->motDePasseUtilisateur;
    }

    public function setPassword(string $motDePasseUtilisateur): self
    {
        $this->motDePasseUtilisateur = $motDePasseUtilisateur;

        return $this;
    }

    // Symfony nécessite une méthode `getUserIdentifier` pour l'authentification. Ici, on retourne l'email.
    public function getUserIdentifier(): string
    {
        return $this->emailUtilisateur;
    }

    // Méthode pour effacer des données sensibles
    public function eraseCredentials(): void
    {
        // Si l'on stockait des données sensibles, c'est ici qu'on les effacerait.
    }

}
