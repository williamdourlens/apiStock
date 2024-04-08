<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie/get', name: 'app_categorie_get')]
    public function index(CategorieRepository $categorieRepository, SerializerInterface $serializer): JsonResponse
    {
        $categorieList = $categorieRepository->findAll();
        $jsonCategorieList = $serializer->serialize($categorieList, 'json');
        return new JsonResponse(
            $jsonCategorieList, Response::HTTP_OK, [], true
        );
    }
}
