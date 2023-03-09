<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $adresse = null;

    #[ORM\Column(length: 30)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: RDV::class)]
    private Collection $RDVs;

    public function __construct()
    {
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
            $rDV->setPatient($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->RDVs->removeElement($rDV)) {
            if ($rDV->getPatient() === $this) {
                $rDV->setPatient(null);
            }
        }

        return $this;
    }
}
