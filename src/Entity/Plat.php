<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeur_energetique = null;

    #[ORM\Column(nullable: true)]
    private ?float $matiere_grasse = null;

    #[ORM\Column(nullable: true)]
    private ?float $glucide = null;

    #[ORM\Column(nullable: true)]
    private ?float $proteine = null;

    #[ORM\Column(nullable: true)]
    private ?float $sel = null;

    #[ORM\Column]
    private ?int $id_categorie = null;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getValeurEnergetique(): ?float
    {
        return $this->valeur_energetique;
    }

    public function setValeurEnergetique(float $valeur_energetique): static
    {
        $this->valeur_energetique = $valeur_energetique;

        return $this;
    }

    public function getMatiereGrasse(): ?float
    {
        return $this->matiere_grasse;
    }

    public function setMatiereGrasse(?float $matiere_grasse): static
    {
        $this->matiere_grasse = $matiere_grasse;

        return $this;
    }

    public function getGlucide(): ?float
    {
        return $this->glucide;
    }

    public function setGlucide(?float $glucide): static
    {
        $this->glucide = $glucide;

        return $this;
    }

    public function getProteine(): ?float
    {
        return $this->proteine;
    }

    public function setProteine(?float $proteine): static
    {
        $this->proteine = $proteine;

        return $this;
    }

    public function getSel(): ?float
    {
        return $this->sel;
    }

    public function setSel(?float $sel): static
    {
        $this->sel = $sel;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(int $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }
}
