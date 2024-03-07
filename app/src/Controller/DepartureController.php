<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DepartureService;
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
    public function saveAjax(Request $request, DepartureService $departureService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $departureService->saveDeparture($data);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error : '.$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    }
}
