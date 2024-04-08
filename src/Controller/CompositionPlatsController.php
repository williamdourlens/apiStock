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
    
    #[Route('/composition_plats/post', name: 'app_compositionPlats_post', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Create a new compositionPlat object
        $compositionPlat = new CompositionPlats();
        // Set the properties of the compositionPlat object based on the received data
        $compositionPlat->setIdPlat($data['id_plat']);
        $compositionPlat->setIdIngredient($data['id_ingredient']);

        // Save the compositionPlat object to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compositionPlat);
        $entityManager->flush();

        // Serialize the created compositionPlat object to JSON
        $jsonCompositionPlat = $serializer->serialize($compositionPlat, 'json');

        return new JsonResponse(
            $jsonCompositionPlat, Response::HTTP_CREATED, [], true
        );
    }
}
