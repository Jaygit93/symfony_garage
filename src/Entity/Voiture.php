<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'voitures')]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $marqueVoiture;

    #[ORM\Column(type: 'string', length: 100)]
    private $modeleVoiture;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $prixVoiture;    

    #[ORM\Column(type: 'integer')]
    private $anneeVoiture;

    #[ORM\Column(type: 'integer')]
    private $kilometrageVoiture;

    #[ORM\Column(type: 'string', length:255)]
    private $imageVoiture;

    #[ORM\Column(type: 'text', nullable: true, length:300)]
    private $equipementsVoiture;

    #[ORM\Column(type: 'text', nullable: true, length:300)]
    private $caracteristiquesVoiture;

    #[ORM\Column(type: 'string', columnDefinition: "ENUM('manuelle', 'automatique')")]
    private $boiteVoiture;

    // Relation avec l'utilisateur (propriétaire de la voiture)
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_utilisateur', referencedColumnName: 'id')]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarqueVoiture(): ?string
    {
        return $this->marqueVoiture;
    }

    public function setMarqueVoiture(string $marqueVoiture): self
    {
        $this->marqueVoiture = $marqueVoiture;

        return $this;
    }

    public function getModeleVoiture(): ?string
    {
        return $this->modeleVoiture;
    }

    public function setModeleVoiture(string $modeleVoiture): self
    {
        $this->modeleVoiture = $modeleVoiture;

        return $this;
    }

    public function getPrixVoiture(): ?int
    {
        return $this->prixVoiture;
    }

    public function setPrixVoiture(int $prixVoiture): self
    {
        $this->prixVoiture = $prixVoiture;

        return $this;
    }

    public function getAnneeVoiture(): ?int
    {
        return $this->anneeVoiture;
    }

    public function setAnneeVoiture(int $anneeVoiture): self
    {
        $this->anneeVoiture = $anneeVoiture;

        return $this;
    }

    public function getKilometrageVoiture(): ?int
    {
        return $this->kilometrageVoiture;
    }

    public function setKilometrageVoiture(int $kilometrageVoiture): self
    {
        $this->kilometrageVoiture = $kilometrageVoiture;

        return $this;
    }

    public function getImageVoiture(): ?string
    {
        return $this->imageVoiture;
    } 

    public function getImageVoitureUrl(): ?string
    {
        if ($this->imageVoiture) {
            return '/img_voitures/' . $this->imageVoiture;
        }
        return null;
    }

    public function setImagevoiture($imageVoiture): self
    {
        $this->imageVoiture = $imageVoiture;
        return $this;
    }

    public function getEquipementsVoiture(): ?string
    {
        return $this->equipementsVoiture;
    }

    public function setEquipementsVoiture(?string $equipementsVoiture): self
    {
        $this->equipementsVoiture = $equipementsVoiture;

        return $this;
    }

    public function getCaracteristiquesVoiture(): ?string
    {
        return $this->caracteristiquesVoiture;
    }

    public function setCaracteristiquesVoiture(?string $caracteristiquesVoiture): self
    {
        $this->caracteristiquesVoiture = $caracteristiquesVoiture;

        return $this;
    }

    public function getBoiteVoiture(): ?string
    {
        return $this->boiteVoiture;
    }

    public function setBoiteVoiture(string $boiteVoiture): self
    {
        $this->boiteVoiture = $boiteVoiture;

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
