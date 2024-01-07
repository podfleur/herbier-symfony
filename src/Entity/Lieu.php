<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'lieu', targetEntity: Releve::class, orphanRemoval: true)]
    private Collection $releves;

    public function __construct()
    {
        $this->releves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Releve>
     */
    public function getReleves(): Collection
    {
        return $this->releves;
    }

    public function addRelefe(Releve $relefe): static
    {
        if (!$this->releves->contains($relefe)) {
            $this->releves->add($relefe);
            $relefe->setLieu($this);
        }

        return $this;
    }

    public function removeRelefe(Releve $relefe): static
    {
        if ($this->releves->removeElement($relefe)) {
            // set the owning side to null (unless already changed)
            if ($relefe->getLieu() === $this) {
                $relefe->setLieu(null);
            }
        }

        return $this;
    }
}