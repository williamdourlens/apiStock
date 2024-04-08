<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
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
}
