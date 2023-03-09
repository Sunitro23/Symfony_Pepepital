<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $nom = null;

    #[ORM\OneToOne(inversedBy: 'medecin', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Assistant $assistant = null;

    #[ORM\OneToMany(mappedBy: 'medecin', targetEntity: Indisponibilite::class)]
    private Collection $indisponibilites;

    #[ORM\OneToMany(mappedBy: 'medecin', targetEntity: RDV::class)]
    private Collection $RDVs;

    public function __construct()
    {
        $this->indisponibilites = new ArrayCollection();
        $this->RDVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAssistant(): ?Assistant
    {
        return $this->assistant;
    }

    public function setAssistant(Assistant $assistant): self
    {
        $this->assistant = $assistant;

        return $this;
    }

    /**
     * @return Collection<int, Indisponibilite>
     */
    public function getIndisponibilites(): Collection
    {
        return $this->indisponibilites;
    }

    public function addIndisponibilite(Indisponibilite $indisponibilite): self
    {
        if (!$this->indisponibilites->contains($indisponibilite)) {
            $this->indisponibilites->add($indisponibilite);
            $indisponibilite->setMedecin($this);
        }

        return $this;
    }

    public function removeIndisponibilite(Indisponibilite $indisponibilite): self
    {
        if ($this->indisponibilites->removeElement($indisponibilite)) {
            // set the owning side to null (unless already changed)
            if ($indisponibilite->getMedecin() === $this) {
                $indisponibilite->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RDV>
     */
    public function getRDVs(): Collection
    {
        return $this->RDVs;
    }

    public function addRDV(RDV $rDV): self
    {
        if (!$this->RDVs->contains($rDV)) {
            $this->RDVs->add($rDV);
            $rDV->setMedecin($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->RDVs->removeElement($rDV)) {
            // set the owning side to null (unless already changed)
            if ($rDV->getMedecin() === $this) {
                $rDV->setMedecin(null);
            }
        }

        return $this;
    }
}
