<?php

namespace App\Controller;

use App\Repository\FournisseurRepository;
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
}
