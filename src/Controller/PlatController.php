<?php

namespace App\Controller;

use App\Repository\PlatRepository;
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
}
