<?php

namespace App\Entity;

use App\Repository\StatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
class Statut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: RDV::class)]
    private Collection $RDVs;

    public function __construct()
    {
        $this->RDVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $rDV->setStatut($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->RDVs->removeElement($rDV)) {
            // set the owning side to null (unless already changed)
            if ($rDV->getStatut() === $this) {
                $rDV->setStatut(null);
            }
        }

        return $this;
    }
}
