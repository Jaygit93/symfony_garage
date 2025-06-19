<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "services")]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $titre_service;

    #[ORM\Column(type: 'text', length: 300)]
    private $description_service;

    #[ORM\Column(type: 'string', length: 255)]
    private $image_service;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreService(): ?string
    {
        return $this->titre_service;
    }

    public function setTitreService(string $titre_service): self
    {
        $this->titre_service = $titre_service;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getImageService(): ?string
    {
        return $this->image_service;
    }

    public function getImageServiceUrl(): ?string
    {
        if ($this->image_service) {
            return '/img_services/' . $this->image_service;
        }
        return null;
    }

    
    public function setImageService(string $image_service): self
    {
        $this->image_service = $image_service;
        return $this;
    }
}
