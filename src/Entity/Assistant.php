<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssistantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistantRepository::class)]
#[ApiResource]
class Assistant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'assistant', cascade: ['persist', 'remove'])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        // unset the owning side of the relation if necessary
        if ($medecin === null && $this->medecin !== null) {
            $this->medecin->setAssistant(null);
        }

        // set the owning side of the relation if necessary
        if ($medecin !== null && $medecin->getAssistant() !== $this) {
            $medecin->setAssistant($this);
        }

        $this->medecin = $medecin;

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
}
