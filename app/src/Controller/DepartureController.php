<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DepartureService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepartureController extends AbstractController
{
    public function __construct() {}

    #[Route(path: '/save-departure', name: 'save-departure')]
    public function saveAjax(Request $request, DepartureService $departureService, LoggerInterface $logger): JsonResponse
    {
        $ajaxResponseDecoded = json_decode($request->getContent(), true);

        if (!is_array($ajaxResponseDecoded) || !isset($ajaxResponseDecoded['stop'], $ajaxResponseDecoded['destination'], $ajaxResponseDecoded['line'], $ajaxResponseDecoded['time'])) {
            return new JsonResponse(['status' => 'error : Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'stop' => (string) $ajaxResponseDecoded['stop'],
            'destination' => (string) $ajaxResponseDecoded['destination'],
            'line' => (string) $ajaxResponseDecoded['line'],
            'time' => (string) $ajaxResponseDecoded['time'],
        ];
        try {
            $departureService->saveDeparture($data);
        } catch (\Exception $e) {
            $logger->error('Error occurred while saving departure', ['error' => $e->getMessage()]);

            return new JsonResponse(['status' => 'error : ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
    }
}
