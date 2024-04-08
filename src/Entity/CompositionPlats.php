<?php

namespace App\Entity;

use App\Repository\CompositionPlatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompositionPlatsRepository::class)]
class CompositionPlats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_plat = null;

    #[ORM\Column]
    private ?int $id_ingredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlat(): ?int
    {
        return $this->id_plat;
    }

    public function setIdPlat(int $id_plat): static
    {
        $this->id_plat = $id_plat;

        return $this;
    }

    public function getIdIngredient(): ?int
    {
        return $this->id_ingredient;
    }

    public function setIdIngredient(int $id_ingredient): static
    {
        $this->id_ingredient = $id_ingredient;

        return $this;
    }
}
