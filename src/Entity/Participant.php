<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Ecurie $ecurie = null;

    /**
     * @var Collection<int, GrandPrix>
     */
    #[ORM\ManyToMany(targetEntity: GrandPrix::class, mappedBy: 'participant')]
    private Collection $grandPrix;

    public function __construct()
    {
        $this->grandPrix = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, GrandPrix>
     */
    public function getGrandPrix(): Collection
    {
        return $this->grandPrix;
    }

    public function addGrandPrix(GrandPrix $grandPrix): static
    {
        if (!$this->grandPrix->contains($grandPrix)) {
            $this->grandPrix->add($grandPrix);
            $grandPrix->addParticipant($this);
        }

        return $this;
    }

    public function removeGrandPrix(GrandPrix $grandPrix): static
    {
        if ($this->grandPrix->removeElement($grandPrix)) {
            $grandPrix->removeParticipant($this);
        }

        return $this;
    }
}
