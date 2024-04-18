<?php

namespace App\Controller;

use App\Entity\CompositionPlats;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CompositionPlatsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

class CompositionPlatsController extends AbstractController
{
    #[Route('/composition_plats/get', name: 'app_compositionPlats_get')]
    public function index(CompositionPlatsRepository $compositionPlatsRepository, SerializerInterface $serializer): JsonResponse
    {
        $compositionPlatsList = $compositionPlatsRepository->findAll();
        $jsonCompositionPlatsList = $serializer->serialize($compositionPlatsList, 'json');
        return new JsonResponse(
            $jsonCompositionPlatsList, Response::HTTP_OK, [], true
        );
    }

    #[Route('/composition_plats/get/{id}', name: 'app_compositionPlats_get_id')]
    public function show(int $id, CompositionPlatsRepository $compositionPlatsRepository, SerializerInterface $serializer): JsonResponse
    {
        $compositionPlat = $compositionPlatsRepository->find($id);

        if ($compositionPlat === null) {
            return new JsonResponse(
                'CompositionPlat not found', Response::HTTP_NOT_FOUND
            );
        }

        $jsonCompositionPlat = $serializer->serialize($compositionPlat, 'json');

        return new JsonResponse(
            $jsonCompositionPlat, Response::HTTP_OK, [], true
        );
    }
    
    #[Route('/composition_plats/post', name: 'app_compositionPlats_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new compositionPlat object
        $compositionPlat = new CompositionPlats();
        // Set the properties of the compositionPlat object based on the received data
        $compositionPlat->setIdPlat($data['id_plat']);
        $compositionPlat->setIdIngredient($data['id_ingredient']);

        // Save the compositionPlat object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($compositionPlat);
        $entityManager->flush();

        // Serialize the created compositionPlat object to JSON
        $jsonCompositionPlat = $serializer->serialize($compositionPlat, 'json');

        return new JsonResponse(
            $jsonCompositionPlat, Response::HTTP_CREATED, [], true
        );
    }

    #[Route('/composition_plats/delete/{id}', name: 'app_compositionPlats_delete', methods: ['DELETE'])]
    public function delete(int $id, CompositionPlatsRepository $compositionPlatsRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $compositionPlat = $compositionPlatsRepository->find($id);

        if ($compositionPlat === null) {
            return new JsonResponse(
                'CompositionPlat not found', Response::HTTP_NOT_FOUND
            );
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($compositionPlat);
        $entityManager->flush();

        return new JsonResponse(
            'Composition deleted', Response::HTTP_OK
        );
    }

    #[Route('/composition_plats/patch/{id}', name: 'app_compositionPlats_patch', methods: ['PATCH'])]
    public function update(int $id, Request $request, CompositionPlatsRepository $compositionPlatsRepository, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $compositionPlat = $compositionPlatsRepository->find($id);

        if ($compositionPlat === null) {
            return new JsonResponse(
                'CompositionPlat not found', Response::HTTP_NOT_FOUND
            );
        }

        $data = json_decode($request->getContent(), true);
        // Set the properties of the compositionPlat object based on the received data
        $compositionPlat->setIdPlat($data['id_plat']);
        $compositionPlat->setIdIngredient($data['id_ingredient']);

        // Save the compositionPlat object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($compositionPlat);
        $entityManager->flush();

        // Serialize the updated compositionPlat object to JSON
        $jsonCompositionPlat = $serializer->serialize($compositionPlat, 'json');

        return new JsonResponse(
            $jsonCompositionPlat, Response::HTTP_OK, [], true
        );
    }
}
