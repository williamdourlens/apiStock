<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\CompositionPlatsRepository;
use App\Repository\PlatRepository;
use App\Repository\IngredientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    #[Route('/ingredient/get', name: 'app_ingredient_get')]
    public function index(IngredientRepository $ingredientRepository, SerializerInterface $serializer): JsonResponse
    {
        $ingredientList = $ingredientRepository->findAll();
        $jsonIngredientList = $serializer->serialize($ingredientList, 'json');
        return new JsonResponse(
            $jsonIngredientList, Response::HTTP_OK, [], true
        );
    }

    #[Route('/ingredient/get/{id}', name: 'app_ingredient_get_id')]
    public function show(int $id, IngredientRepository $ingredientRepository, SerializerInterface $serializer): JsonResponse
    {
        $ingredient = $ingredientRepository->find($id);

        if ($ingredient === null) {
            return new JsonResponse(
                'Ingredient not found', Response::HTTP_NOT_FOUND
            );
        }

        $jsonIngredient = $serializer->serialize($ingredient, 'json');

        return new JsonResponse(
            $jsonIngredient, Response::HTTP_OK, [], true
        );
    }

    #[Route('/ingredient/post', name: 'app_ingredient_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new ingredient object
        $ingredient = new Ingredient();
        // Set the properties of the ingredient object based on the received data
        $ingredient->setNom($data['nom']);
        $ingredient->setQuantite($data['quantite']);
        $ingredient->setAllergene($data['isAllergene']);
        $ingredient->setIdFournisseur($data['id_fournisseur']);

        // Save the ingredient object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($ingredient);
        $entityManager->flush();

        // Serialize the created ingredient object to JSON
        $jsonIngredient = $serializer->serialize($ingredient, 'json');

        return new JsonResponse(
            $jsonIngredient, Response::HTTP_CREATED, [], true
        );
    }

    #[Route('/ingredient/delete/{id}', name: 'app_ingredient_delete', methods: ['DELETE'])]
    public function delete(int $id, IngredientRepository $ingredientRepository, PlatRepository $platRepository, CompositionPlatsRepository $compositionPlatsRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $ingredient = $ingredientRepository->find($id);

        if ($ingredient === null) {
            return new JsonResponse(
                'Categorie not found', Response::HTTP_NOT_FOUND
            );
        }

        $entityManager = $doctrine->getManager();

        // Remove all the associated plats and compositionPlats
        $compositionPlats = $compositionPlatsRepository->findBy(['id_ingredient' => $id]);
        if ($compositionPlats != null) {
            foreach ($compositionPlats as $compositionPlat) {
                $plat = $platRepository->find($compositionPlat->getIdPlat());
                $entityManager->remove($plat);
                $entityManager->remove($compositionPlat);
            }
        }

        $entityManager->remove($ingredient);
        $entityManager->flush();

        return new JsonResponse(
            'Ingredient deleted', Response::HTTP_OK
        );
    }

    #[Route('/ingredient/patch/{id}', name: 'app_ingredient_patch', methods: ['PATCH'])]
    public function update(int $id, Request $request, IngredientRepository $ingredientRepository, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $ingredient = $ingredientRepository->find($id);

        if ($ingredient === null) {
            return new JsonResponse(
                'Ingredient not found', Response::HTTP_NOT_FOUND
            );
        }

        $data = json_decode($request->getContent(), true);
        // Set the properties of the ingredient object based on the received data
        $ingredient->setNom($data['nom']);
        $ingredient->setQuantite($data['quantite']);
        $ingredient->setAllergene($data['isAllergene']);
        $ingredient->setIdFournisseur($data['id_fournisseur']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($ingredient);
        $entityManager->flush();

        $jsonIngredient = $serializer->serialize($ingredient, 'json');

        return new JsonResponse(
            $jsonIngredient, Response::HTTP_OK, [], true
        );
    }
}
