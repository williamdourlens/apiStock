<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

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

    #[Route('/categorie/post', name: 'app_categorie_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new categorie object
        $categorie = new Categorie();
        // Set the properties of the categorie object based on the received data
        $categorie->setNom($data['nom']);

        // Save the categorie object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($categorie);
        $entityManager->flush();

        // Serialize the created categorie object to JSON
        $jsonCategorie = $serializer->serialize($categorie, 'json');

        return new JsonResponse(
            $jsonCategorie, Response::HTTP_CREATED, [], true
        );
    }
}
