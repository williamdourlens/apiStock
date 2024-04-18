<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CompositionPlatsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlatController extends AbstractController
{
    #[Route('/plat/get', name: 'app_plat_get')]
    public function index(PlatRepository $platRepository, SerializerInterface $serializer): JsonResponse
    {
        $platList = $platRepository->findAll();
        $jsonPlatList = $serializer->serialize($platList, 'json');
        return new JsonResponse(
            $jsonPlatList, Response::HTTP_OK, [], true
        );
    }

    #[Route('/plat/get/{id}', name: 'app_plat_get_id')]
    public function show(int $id, PlatRepository $platRepository, SerializerInterface $serializer): JsonResponse
    {
        $plat = $platRepository->find($id);

        if ($plat === null) {
            return new JsonResponse(
                'Plat not found', Response::HTTP_NOT_FOUND
            );
        }

        $jsonPlat = $serializer->serialize($plat, 'json');

        return new JsonResponse(
            $jsonPlat, Response::HTTP_OK, [], true
        );
    }

    #[Route('/plat/post', name: 'app_plat_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new plat object
        $plat = new Plat();
        // Set the properties of the plat object based on the received data
        $plat->setNom($data['nom']);
        $plat->setPrix($data['prix']);
        $plat->setDescription($data['description']);
        $plat->setQuantite($data['quantite']);
        $plat->setValeurEnergetique($data['valeur_energetique']);
        $plat->setMatiereGrasse($data['matiere_grasse']);
        $plat->setGlucide($data['glucide']);
        $plat->setProteine($data['proteine']);
        $plat->setSel($data['sel']);
        $plat->setIdCategorie($data['id_categorie']);

        // Save the plat object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($plat);
        $entityManager->flush();

        // Serialize the created plat object to JSON
        $jsonPlat = $serializer->serialize($plat, 'json');

        return new JsonResponse(
            $jsonPlat, Response::HTTP_CREATED, [], true
        );
    }

    #[Route('/plat/delete/{id}', name: 'app_plat_delete', methods: ['DELETE'])]
    public function delete(int $id, PlatRepository $platRepository, CompositionPlatsRepository $compositionPlatsRepository, ManagerRegistry $doctrine): JsonResponse
    {
        $plat = $platRepository->find($id);

        if ($plat === null) {
            return new JsonResponse(
                'Categorie not found', Response::HTTP_NOT_FOUND
            );
        }

        $entityManager = $doctrine->getManager();

        // Remove all the associated compositionPlats
        $compositionPlats = $compositionPlatsRepository->findBy(['id_plat' => $id]);
        foreach ($compositionPlats as $compositionPlat) {
            $entityManager->remove($compositionPlat);
        }

        $entityManager->remove($plat);
        $entityManager->flush();

        return new JsonResponse(
            'Plat deleted', Response::HTTP_OK
        );
    }

    #[Route('/plat/patch/{id}', name: 'app_plat_patch', methods: ['PATCH'])]
    public function update(int $id, Request $request, PlatRepository $platRepository, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $plat = $platRepository->find($id);

        if ($plat === null) {
            return new JsonResponse(
                'Plat not found', Response::HTTP_NOT_FOUND
            );
        }

        $data = json_decode($request->getContent(), true);
        // Set the properties of the plat object based on the received data
        $plat->setNom($data['nom']);
        $plat->setPrix($data['prix']);
        $plat->setDescription($data['description']);
        $plat->setQuantite($data['quantite']);
        $plat->setValeurEnergetique($data['valeur_energetique']);
        $plat->setMatiereGrasse($data['matiere_grasse']);
        $plat->setGlucide($data['glucide']);
        $plat->setProteine($data['proteine']);
        $plat->setSel($data['sel']);
        $plat->setIdCategorie($data['id_categorie']);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($plat);
        $entityManager->flush();

        return new JsonResponse(
            'Plat updated', Response::HTTP_OK
        );
    }
}
