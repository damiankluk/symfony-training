<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Departure;
use App\Service\DeparturesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartureController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: '/save-departure', name: 'save-departure')]
    public function saveAjax(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $departure = new Departure();
        $departure->setBusStop($data['line']);
        $departure->setDestination($data['destination']);
        try {
            $departure->setTime(new \DateTimeImmutable($data['time']));
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error : '.$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($departure);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    }
}
