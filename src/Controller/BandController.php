<?php

namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/bands')] 
final class BandController extends AbstractController
{
    #[Route('/', name: 'api_band_index', methods: ['GET'])]
    public function index(BandRepository $bandRepository): JsonResponse
    {
        $bands = $bandRepository->findAll();
        $data = [];

        foreach ($bands as $band) {
            $data[] = [
                'id' => $band->getId(),
                'name' => $band->getName(),
                'origin' => $band->getOrigin(),
                'city' => $band->getCity(),
                'startYear' => $band->getStartYear(),
                'separationYear' => $band->getSeparationYear(),
                'founders' => $band->getFounders(),
                'members' => $band->getMembers(),
                'musicalStyle' => $band->getMusicalStyle(),
                'presentation' => $band->getPresentation(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'api_band_show', methods: ['GET'])]
    public function show(Band $band): JsonResponse
    {
        $data = [
            'id' => $band->getId(),
            'name' => $band->getName(),
            'origin' => $band->getOrigin(),
            'city' => $band->getCity(),
            'startYear' => $band->getStartYear(),
            'separationYear' => $band->getSeparationYear(),
            'founders' => $band->getFounders(),
            'members' => $band->getMembers(),
            'musicalStyle' => $band->getMusicalStyle(),
            'presentation' => $band->getPresentation(),
        ];

        return new JsonResponse($data);
    }

    #[Route('/', name: 'api_band_create', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $band = new Band();
        $band->setName($data['name']);
        $band->setOrigin($data['origin']);
        $band->setCity($data['city']);
        $band->setStartYear((int)$data['startYear']);
        $band->setSeparationYear((int)$data['separationYear']);
        $band->setFounders($data['founders']);
        $band->setMembers($data['members']);
        $band->setMusicalStyle($data['musicalStyle']);
        $band->setPresentation($data['presentation']);

        $entityManager->persist($band);
        $entityManager->flush();

        return new JsonResponse(['id' => $band->getId()], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_band_update', methods: ['PUT'])]
    public function edit(Request $request, Band $band, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $band->setName($data['name'] ?? $band->getName());
        $band->setOrigin($data['origin'] ?? $band->getOrigin());
        $band->setCity($data['city'] ?? $band->getCity());
        $band->setStartYear((int)($data['startYear'] ?? $band->getStartYear()));
        $band->setSeparationYear((int)($data['separationYear'] ?? $band->getSeparationYear()));
        $band->setFounders($data['founders'] ?? $band->getFounders());
        $band->setMembers($data['members'] ?? $band->getMembers());
        $band->setMusicalStyle($data['musicalStyle'] ?? $band->getMusicalStyle());
        $band->setPresentation($data['presentation'] ?? $band->getPresentation());

        $entityManager->flush();

        return new JsonResponse(['id' => $band->getId()]);
    }

    #[Route('/{id}', name: 'api_band_delete', methods: ['DELETE'])]
    public function delete(Band $band, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($band);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}