<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomVoiture = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $moteur = null;

    #[ORM\Column(length: 255)]
    private ?string $imgVoiture = null;

    #[ORM\ManyToOne(inversedBy: 'voiture')]
    private ?Ecurie $ecurie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVoiture(): ?string
    {
        return $this->nomVoiture;
    }

    public function setNomVoiture(string $nomVoiture): static
    {
        $this->nomVoiture = $nomVoiture;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMoteur(): ?string
    {
        return $this->moteur;
    }

    public function setMoteur(string $moteur): static
    {
        $this->moteur = $moteur;

        return $this;
    }

    public function getImgVoiture(): ?string
    {
        return $this->imgVoiture;
    }

    public function setImgVoiture(string $imgVoiture): static
    {
        $this->imgVoiture = $imgVoiture;

        return $this;
    }

    public function getEcurie(): ?Ecurie
    {
        return $this->ecurie;
    }

    public function setEcurie(?Ecurie $ecurie): static
    {
        $this->ecurie = $ecurie;

        return $this;
    }
}
