<?php

namespace App\Entity;

use App\Repository\CircuitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CircuitRepository::class)]
class Circuit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCircuit = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column]
    private ?int $nbTour = null;

    #[ORM\Column]
    private ?float $distanceCircuit = null;

    /**
     * @var Collection<int, GrandPrix>
     */
    #[ORM\OneToMany(targetEntity: GrandPrix::class, mappedBy: 'circuit')]
    private Collection $grandPrixes;

    public function __construct()
    {
        $this->grandPrixes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCircuit(): ?string
    {
        return $this->nomCircuit;
    }

    public function setNomCircuit(string $nomCircuit): static
    {
        $this->nomCircuit = $nomCircuit;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNbTour(): ?int
    {
        return $this->nbTour;
    }

    public function setNbTour(int $nbTour): static
    {
        $this->nbTour = $nbTour;

        return $this;
    }

    public function getDistanceCircuit(): ?float
    {
        return $this->distanceCircuit;
    }

    public function setDistanceCircuit(float $distanceCircuit): static
    {
        $this->distanceCircuit = $distanceCircuit;

        return $this;
    }

    /**
     * @return Collection<int, GrandPrix>
     */
    public function getGrandPrixes(): Collection
    {
        return $this->grandPrixes;
    }

    public function addGrandPrix(GrandPrix $grandPrix): static
    {
        if (!$this->grandPrixes->contains($grandPrix)) {
            $this->grandPrixes->add($grandPrix);
            $grandPrix->setCircuit($this);
        }

        return $this;
    }

    public function removeGrandPrix(GrandPrix $grandPrix): static
    {
        if ($this->grandPrixes->removeElement($grandPrix)) {
            // set the owning side to null (unless already changed)
            if ($grandPrix->getCircuit() === $this) {
                $grandPrix->setCircuit(null);
            }
        }

        return $this;
    }
}
