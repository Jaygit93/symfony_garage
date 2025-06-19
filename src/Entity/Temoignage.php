<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "temoignages")]
class Temoignage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private $nomTemoignage;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(max: 400)]
    private $commentaireTemoignage;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 1, max: 5)]
    private $noteTemoignage;

    #[ORM\Column(type: 'boolean')]
    private $approuveTemoignage = false;

    #[ORM\Column(type: 'datetime')]
    private $datePublicationTemoignage;

    #[ORM\ManyToOne(targetEntity: Voiture::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_voiture', referencedColumnName: 'id')]
    private $voiture;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_utilisateur', referencedColumnName: 'id')]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTemoignage(): ?string
    {
        return $this->nomTemoignage;
    }

    public function setNomTemoignage(string $nomTemoignage): self
    {
        $this->nomTemoignage = $nomTemoignage;
        return $this;
    }

    public function getCommentaireTemoignage(): ?string
    {
        return $this->commentaireTemoignage;
    }

    public function setCommentaireTemoignage(string $commentaireTemoignage): self
    {
        $this->commentaireTemoignage = $commentaireTemoignage;
        return $this;
    }

    public function getNoteTemoignage(): ?int
    {
        return $this->noteTemoignage;
    }

    public function setNoteTemoignage(int $noteTemoignage): self
    {
        $this->noteTemoignage = $noteTemoignage;
        return $this;
    }

    public function isApprouveTemoignage(): ?bool
    {
        return $this->approuveTemoignage;
    }

    public function setApprouveTemoignage(bool $approuveTemoignage): self
    {
        $this->approuveTemoignage = $approuveTemoignage;
        return $this;
    }

    public function getDatePublicationTemoignage(): ?\DateTimeInterface
    {
        return $this->datePublicationTemoignage;
    }

    public function setDatePublicationTemoignage(\DateTimeInterface $datePublicationTemoignage): self
    {
        $this->datePublicationTemoignage = $datePublicationTemoignage;
        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;
        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
