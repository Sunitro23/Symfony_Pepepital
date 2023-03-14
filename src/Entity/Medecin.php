<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ApiResource]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'medecin', cascade: ['persist', 'remove'])]
    private ?Assistant $assistant = null;

    #[ORM\OneToMany(mappedBy: 'medecin', targetEntity: RDV::class, orphanRemoval: true)]
    private Collection $rdvs;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'medecin', targetEntity: Indisponibilite::class, orphanRemoval: true)]
    private Collection $indisponibilites;

    public function __construct()
    {
        $this->rdvs = new ArrayCollection();
        $this->indisponibilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssistant(): ?Assistant
    {
        return $this->assistant;
    }

    public function setAssistant(?Assistant $assistant): self
    {
        $this->assistant = $assistant;

        return $this;
    }

    /**
     * @return Collection<int, RDV>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(RDV $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setMedecin($this);
        }

        return $this;
    }

    public function removeRdv(RDV $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getMedecin() === $this) {
                $rdv->setMedecin(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
}
