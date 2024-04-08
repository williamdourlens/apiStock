<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Fournisseur;
use App\Entity\CompositionPlats;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Categories
        for ($i = 0; $i < 10; $i++) {
            $categorie = new Categorie();
            $categorie->setNom('Categorie ' . $i);

            $manager->persist($categorie);
        }

        // Plats
        for ($i = 0; $i < 10; $i++) {
            $plat = new Plat();
            $plat->setNom('Plat ' . $i);
            $plat->setPrix($i * 10);
            $plat->setDescription('Description Plat ' . $i);
            $plat->setQuantite($i * 100);
            $plat->setValeurEnergetique($i * 100);
            $plat->setMatiereGrasse($i * 100);
            $plat->setGlucide($i * 100);
            $plat->setProteine($i * 100);
            $plat->setSel($i * 100);
            $plat->setIdCategorie($i + 1);

            $manager->persist($plat);
        }

        // Fournisseurs
        for ($i = 0; $i < 10; $i++) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNom('Fournisseur ' . $i);
            $fournisseur->setAdresse('Adresse Fournisseur ' . $i);
            $fournisseur->setTelephone('060000000' . $i);
            $fournisseur->setEmail('fournisseur' . $i . '@gmail.com');

            $manager->persist($fournisseur);
        }

        // Ingredients
        for ($i = 0; $i < 10; $i++) {
            $random = random_int(0, 1);
            $ingredient = new Ingredient();
            $ingredient->setNom('Ingredient ' . $i);
            $ingredient->setQuantite($i * 100);
            if ($random === 0) $ingredient->setAllergene(false);
            else $ingredient->setAllergene(true);
            $ingredient->setIdFournisseur($i + 1);

            $manager->persist($ingredient);
        }

        // Compositions Plats
        for ($i = 0; $i < 10; $i++) {
            $randomPlat = random_int(1, 10);
            $randomIngredient = random_int(1, 10);
            $compositionPlats = new CompositionPlats();
            $compositionPlats->setIdPlat($randomPlat);
            $compositionPlats->setIdIngredient($randomIngredient);

            $manager->persist($compositionPlats);
        }

        $manager->flush();
    }
}
