<?php

namespace App\Entity;

use App\Repository\EcurieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EcurieRepository::class)]
class Ecurie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEcurie = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\Column]
    private ?int $nbTitreEcurie = null;

    /**
     * @var Collection<int, Pilote>
     */
    #[ORM\OneToMany(targetEntity: Pilote::class, mappedBy: 'ecurie')]
    private Collection $pilote;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'ecurie')]
    private Collection $voiture;

    public function __construct()
    {
        $this->pilote = new ArrayCollection();
        $this->voiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEcurie(): ?string
    {
        return $this->nomEcurie;
    }

    public function setNomEcurie(string $nomEcurie): static
    {
        $this->nomEcurie = $nomEcurie;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNbTitreEcurie(): ?int
    {
        return $this->nbTitreEcurie;
    }

    public function setNbTitreEcurie(int $nbTitreEcurie): static
    {
        $this->nbTitreEcurie = $nbTitreEcurie;

        return $this;
    }

    /**
     * @return Collection<int, Pilote>
     */
    public function getPilote(): Collection
    {
        return $this->pilote;
    }

    public function addPilote(Pilote $pilote): static
    {
        if (!$this->pilote->contains($pilote)) {
            $this->pilote->add($pilote);
            $pilote->setEcurie($this);
        }

        return $this;
    }

    public function removePilote(Pilote $pilote): static
    {
        if ($this->pilote->removeElement($pilote)) {
            // set the owning side to null (unless already changed)
            if ($pilote->getEcurie() === $this) {
                $pilote->setEcurie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoiture(): Collection
    {
        return $this->voiture;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voiture->contains($voiture)) {
            $this->voiture->add($voiture);
            $voiture->setEcurie($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voiture->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getEcurie() === $this) {
                $voiture->setEcurie(null);
            }
        }

        return $this;
    }
}
