<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Lleego\Availability\Application\GetAvailabilityDataProviderRequest;
use App\Lleego\Availability\Application\GetAvailabilityDataProviderService;
use App\Lleego\Shared\Domain\Response\JsonResponse as ApiJsonResponse;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/avail', name: 'app_api_availability_price_')]
class AvailabilityPriceController extends AbstractController
{
    #[Route('/', name: 'get_provider_data', methods: ['GET'])]
    public function index(
        Request $request,
        GetAvailabilityDataProviderService $getProviderDataService
    ): JsonResponse {
        $getDataProviderResponseJsonArray = null;

        try {
            $params = [];
            $requestParams = $request->getQueryString();

            if (
                $requestParams !== null
                && !empty($requestParams)
            ) {
                parse_str($requestParams, $params);
            }

            $getDataProviderRequest = GetAvailabilityDataProviderRequest::createFromArray($params);
            $getDataProviderResponse = $getProviderDataService->execute($getDataProviderRequest);
            $getDataProviderResponseJsonArray = ApiJsonResponse::convertObjectToArray($getDataProviderResponse);

            $http_status = Response::HTTP_OK;
        } catch (BadRequestException $e) {
            $http_status = Response::HTTP_BAD_REQUEST;
            $getDataProviderResponseJsonArray = ['error' => $e->getMessage()];
        } catch(Exception $e) {
            $http_status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $getDataProviderResponseJsonArray = ['error' => $e->getMessage()];
        } catch(Error $e) {
            $http_status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $getDataProviderResponseJsonArray = ['error' => $e->getMessage()];
        }

        return $this->json(
            $getDataProviderResponseJsonArray,
            $http_status
        );
    }
}
