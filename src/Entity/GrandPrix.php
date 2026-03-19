<?php

namespace App\Entity;

use App\Repository\GrandPrixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrandPrixRepository::class)]
class GrandPrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dateDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $heureDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $heureFin = null;

    #[ORM\ManyToOne(inversedBy: 'grandPrixes')]
    private ?Circuit $circuit = null;

    #[ORM\ManyToOne(inversedBy: 'grandPrixes')]
    private ?Meteo $meteo = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'grandPrixes')]
    private Collection $participant;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getHeureDebut(): ?string
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(string $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?string
    {
        return $this->heureFin;
    }

    public function setHeureFin(string $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuit $circuit): static
    {
        $this->circuit = $circuit;

        return $this;
    }

    public function getMeteo(): ?Meteo
    {
        return $this->meteo;
    }

    public function setMeteo(?Meteo $meteo): static
    {
        $this->meteo = $meteo;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participant->contains($participant)) {
            $this->participant->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        $this->participant->removeElement($participant);

        return $this;
    }
}
