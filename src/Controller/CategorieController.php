<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
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

    #[Route('/categorie/get/{id}', name: 'app_categorie_get_id')]
    public function show(int $id, CategorieRepository $categorieRepository, SerializerInterface $serializer): JsonResponse
    {
        $categorie = $categorieRepository->find($id);

        if ($categorie === null) {
            return new JsonResponse(
                'Categorie not found', Response::HTTP_NOT_FOUND
            );
        }

        $jsonCategorie = $serializer->serialize($categorie, 'json');

        return new JsonResponse(
            $jsonCategorie, Response::HTTP_OK, [], true
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

    #[Route('/categorie/delete/{id}', name: 'app_categorie_delete', methods: ['DELETE'])]
    public function delete(int $id, CategorieRepository $categorieRepository, PlatRepository $platRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $categorie = $categorieRepository->find($id);

        if ($categorie === null) {
            return new JsonResponse(
                'Categorie not found', Response::HTTP_NOT_FOUND
            );
        }

        $entityManager = $doctrine->getManager();

        // Remove all the associated plats
        $plats = $platRepository->findBy(['id_categorie' => $id]);
        foreach ($plats as $plat) {
            $entityManager->remove($plat);
        }

        $entityManager->remove($categorie);
        $entityManager->flush();

        return new JsonResponse(
            'Categorie deleted', Response::HTTP_OK
        );
    }

    #[Route('/categorie/patch/{id}', name: 'app_categorie_patch', methods: ['PATCH'])]
    public function update(int $id, Request $request, CategorieRepository $categorieRepository, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $categorie = $categorieRepository->find($id);

        if ($categorie === null) {
            return new JsonResponse(
                'Categorie not found', Response::HTTP_NOT_FOUND
            );
        }

        $data = json_decode($request->getContent(), true);
        $categorie->setNom($data['nom']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($categorie);
        $entityManager->flush();

        $jsonCategorie = $serializer->serialize($categorie, 'json');

        return new JsonResponse(
            $jsonCategorie, Response::HTTP_OK, [], true
        );
    }
}
