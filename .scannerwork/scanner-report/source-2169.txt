<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssistantRepository;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: AssistantRepository::class)]
#[ApiResource]
class Assistant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'assistant', cascade: ['persist', 'remove'])]
    #[MaxDepth(1)]
    #[Groups(["exclude_circular_reference"])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    #[Groups(["exclude_circular_reference"])]
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
