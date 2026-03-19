<?php

namespace App\Entity;

use App\Repository\PiloteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiloteRepository::class)]
class Pilote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPilote = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomPilote = null;

    #[ORM\Column(length: 2)]
    private ?string $age = null;

    #[ORM\Column]
    private ?int $nbTitrePilote = null;

    #[ORM\Column(length: 255)]
    private ?string $imgPilote = null;

    #[ORM\ManyToOne(inversedBy: 'pilote')]
    private ?Ecurie $ecurie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPilote(): ?string
    {
        return $this->nomPilote;
    }

    public function setNomPilote(string $nomPilote): static
    {
        $this->nomPilote = $nomPilote;

        return $this;
    }

    public function getPrenomPilote(): ?string
    {
        return $this->prenomPilote;
    }

    public function setPrenomPilote(string $prenomPilote): static
    {
        $this->prenomPilote = $prenomPilote;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getNbTitrePilote(): ?int
    {
        return $this->nbTitrePilote;
    }

    public function setNbTitrePilote(int $nbTitrePilote): static
    {
        $this->nbTitrePilote = $nbTitrePilote;

        return $this;
    }

    public function getImgPilote(): ?string
    {
        return $this->imgPilote;
    }

    public function setImgPilote(string $imgPilote): static
    {
        $this->imgPilote = $imgPilote;

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
