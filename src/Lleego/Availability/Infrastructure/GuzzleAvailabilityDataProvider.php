<?php

namespace App\Lleego\Availability\Infrastructure;

use App\Lleego\Availability\Domain\AvailabilityDataProviderInterface;
use App\Lleego\Shared\Domain\Xml\Xml;
use DateTimeInterface;
use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GuzzleAvailabilityDataProvider implements AvailabilityDataProviderInterface
{
    public function getXmlDataAsArray(
        string $origin,
        string $destination,
        DateTimeInterface $dateTime
    ): ?array {
        $urlParams = [
            'origin' => $origin,
            'destination' => $destination,
            'date' => $dateTime->format('Y-m-d')
        ];

        $url = $_ENV['API_BASE_URL'] . $_ENV['API_BASE_URL_AVAILABILITY_PRICE'];
        $method = 'GET';
        $client = new Client();
        $response = $client->request(
            $method,
            $url,
            ['query' => $urlParams]
        );

        if ($response->getStatusCode() === 400) {
            throw new BadRequestException('External error: ' . $response->getBody()->getContents());
        } elseif ($response->getStatusCode() !== 200) {
            throw new Exception('Unexpected error');
        }

        return Xml::convertFromStringXmlToArray($response->getBody()->getContents());
    }
}
