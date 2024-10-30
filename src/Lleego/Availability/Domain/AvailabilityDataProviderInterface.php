<?php

namespace App\Lleego\Availability\Domain;

use DateTimeInterface;

interface AvailabilityDataProviderInterface
{
    public function getXmlDataAsArray(
        string $origin, 
        string $destination, 
        DateTimeInterface $dateTime
    ): ?array;
}
