<?php

namespace App\Entity;

use App\Repository\MeteoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeteoRepository::class)]
class Meteo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomMeteo = null;

    /**
     * @var Collection<int, GrandPrix>
     */
    #[ORM\OneToMany(targetEntity: GrandPrix::class, mappedBy: 'meteo')]
    private Collection $grandPrixes;

    public function __construct()
    {
        $this->grandPrixes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMeteo(): ?string
    {
        return $this->nomMeteo;
    }

    public function setNomMeteo(string $nomMeteo): static
    {
        $this->nomMeteo = $nomMeteo;

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
            $grandPrix->setMeteo($this);
        }

        return $this;
    }

    public function removeGrandPrix(GrandPrix $grandPrix): static
    {
        if ($this->grandPrixes->removeElement($grandPrix)) {
            // set the owning side to null (unless already changed)
            if ($grandPrix->getMeteo() === $this) {
                $grandPrix->setMeteo(null);
            }
        }

        return $this;
    }
}
