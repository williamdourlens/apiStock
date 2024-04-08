<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?bool $isAllergene = null;

    #[ORM\Column]
    private ?int $id_fournisseur = null;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function isAllergene(): ?bool
    {
        return $this->isAllergene;
    }

    public function setAllergene(bool $isAllergene): static
    {
        $this->isAllergene = $isAllergene;

        return $this;
    }

    public function getIdFournisseur(): ?int
    {
        return $this->id_fournisseur;
    }

    public function setIdFournisseur(int $id_fournisseur): static
    {
        $this->id_fournisseur = $id_fournisseur;

        return $this;
    }
}
