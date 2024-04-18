<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FournisseurController extends AbstractController
{
    #[Route('/fournisseur/get', name: 'app_fournisseur_get')]
    public function index(FournisseurRepository $fournisseurRepository, SerializerInterface $serializer): JsonResponse
    {
        $fournisseurList = $fournisseurRepository->findAll();
        $jsonFournisseurList = $serializer->serialize($fournisseurList, 'json');
        return new JsonResponse(
            $jsonFournisseurList, Response::HTTP_OK, [], true
        );
    }

    #[Route('/fournisseur/get/{id}', name: 'app_fournisseur_get_id')]
    public function show(int $id, FournisseurRepository $fournisseurRepository, SerializerInterface $serializer): JsonResponse
    {
        $fournisseur = $fournisseurRepository->find($id);

        if ($fournisseur === null) {
            return new JsonResponse(
                'Fournisseur not found', Response::HTTP_NOT_FOUND
            );
        }

        $jsonFournisseur = $serializer->serialize($fournisseur, 'json');

        return new JsonResponse(
            $jsonFournisseur, Response::HTTP_OK, [], true
        );
    }

    /*
    #[Route('/fournisseur/post', name: 'app_fournisseur_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new fournisseur object
        $fournisseur = new Fournisseur();
        // Set the properties of the fournisseur object based on the received data
        $fournisseur->setNom($data['nom']);
        $fournisseur->setAdresse($data['adresse']);
        $fournisseur->setTelephone($data['telephone']);
        $fournisseur->setEmail($data['email']);

        // Save the fournisseur object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($fournisseur);
        $entityManager->flush();

        // Serialize the created fournisseur object to JSON
        $jsonFournisseur = $serializer->serialize($fournisseur, 'json');

        return new JsonResponse(
            $jsonFournisseur, Response::HTTP_CREATED, [], true
        );
    }
    */
}
