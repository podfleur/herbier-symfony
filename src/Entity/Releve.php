<?php

namespace App\Entity;

use App\Repository\ReleveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Random\RandomException;

#[ORM\Entity(repositoryClass: ReleveRepository::class)]
class Releve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'releves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[ORM\Column(length: 17)]
    private ?string $releve_brut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReleveBrut(): ?string
    {
        return $this->releve_brut;
    }

    public function setReleveBrut(string $releve_brut): static
    {
        $this->releve_brut = $releve_brut;

        return $this;
    }

    /**
     * @throws RandomException
     */
    public function generateTable(): array
    {
        $matrice = [];
        $releve_brut = array_map('intval', explode('/', $this->getReleveBrut()));
    
        for ($y = 0; $y < 3; $y++) {
            $matrice[$y] = [];
            for ($x = 0; $x < 3; $x++) {
                $matrice[$y][$x] = [];
    
                for ($i = 0; $i < $releve_brut[$y * 3 + $x]; $i++) {
                    $index = random_int(0, 8);
                    while (in_array($index, $matrice[$y][$x])) {
                        $index = random_int(0, 8);
                    }
    
                    $matrice[$y][$x][] = $index;
                }
            }
        }
        return $matrice;
    }    
}