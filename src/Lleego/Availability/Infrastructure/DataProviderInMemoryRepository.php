<?php

namespace App\Lleego\Availability\Infrastructure;

use App\Lleego\Availability\Domain\AvailabilityDataProviderInterface;
use App\Lleego\Shared\Domain\Xml\Xml;
use DateTimeInterface;
use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DataProviderInMemoryRepository implements AvailabilityDataProviderInterface
{
    public function getXmlDataAsArray(
        string $origin,
        string $destination,
        DateTimeInterface $dateTime
    ): ?array {
        return [
            'DataLists' => [
                'FlightSegmentList' => [
                    'FlightSegment' => [
                        [
                            'Departure' => [
                                'AirportCode' => 'MAD',
                                'Date' => '2022-06-01',
                                'Time' => '11:50',
                                'AirportName' => 'Madrid Adolfo Suarez-Barajas',
                            ],
                            'Arrival' => [
                                'AirportCode' => 'BIO',
                                'Date' => '2022-06-01',
                                'Time' => '12:55',
                                'ChangeOfDay' => '0',
                                'AirportName' => 'Bilbao'
                            ], 
                            'MarketingCarrier' => [
                                'AirlineID' => 'IB',
                                'Name' => 'Iberia',
                                'FlightNumber' => '0426'
                            ]
                        ],
                        [
                            'Departure' => [
                                'AirportCode' => 'MAD',
                                'Date' => '2022-06-01',
                                'Time' => '11:50',
                                'AirportName' => 'Madrid Adolfo Suarez-Barajas',
                            ],
                            'Arrival' => [
                                'AirportCode' => 'BIO',
                                'Date' => '2022-06-01',
                                'Time' => '12:55',
                                'ChangeOfDay' => '0',
                                'AirportName' => 'Bilbao'
                            ], 
                            'MarketingCarrier' => [
                                'AirlineID' => 'IB',
                                'Name' => 'Iberia',
                                'FlightNumber' => '0427'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
