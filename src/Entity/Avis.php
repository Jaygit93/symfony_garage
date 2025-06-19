<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "avis")]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    #[ORM\JoinColumn(name: 'nom_avis')]
    private $nomAvis;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(max: 400)]
    #[ORM\JoinColumn(name: 'commentaire_avis')]
    private $commentaireAvis;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 1, max: 5)]
    #[ORM\JoinColumn(name: 'note_avis')]
    private $noteAvis;

    #[ORM\Column(type: 'boolean')]
    #[ORM\JoinColumn(name: 'approuve_avis')]
    private $approuveAvis = false;

    #[ORM\Column(type: 'datetime')]
    #[ORM\JoinColumn(name: 'date_publication_avis')]
    private $datePublicationAvis;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_utilisateur', referencedColumnName: 'id')]
    private $utilisateur;

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAvis(): ?string
    {
        return $this->nomAvis;
    }

    public function setNomAvis(string $nomAvis): self
    {
        $this->nomAvis = $nomAvis;
        return $this;
    }

    public function getCommentaireAvis(): ?string
    {
        return $this->commentaireAvis;
    }

    public function setCommentaireAvis(string $commentaireAvis): self
    {
        $this->commentaireAvis = $commentaireAvis;
        return $this;
    }

    public function getNoteAvis(): ?int
    {
        return $this->noteAvis;
    }

    public function setNoteAvis(int $noteAvis): self
    {
        $this->noteAvis = $noteAvis;
        return $this;
    }

    public function isApprouveAvis(): ?bool
    {
        return $this->approuveAvis;
    }

    public function setApprouveAvis(bool $approuveAvis): self
    {
        $this->approuveAvis = $approuveAvis;
        return $this;
    }

    public function getDatePublicationAvis(): ?\DateTimeInterface
    {
        return $this->datePublicationAvis;
    }

    public function setDatePublicationAvis(\DateTimeInterface $datePublicationAvis): self
    {
        $this->datePublicationAvis = $datePublicationAvis;
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