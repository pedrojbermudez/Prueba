<?php

declare(strict_types=1);

namespace App\Lleego\Availability\Application;

use App\Lleego\Availability\Domain\AvailabilityDataProviderInterface;

abstract class AvailabilityDataProviderService
{
    protected $availabilityDataProvider;

    public function __construct(AvailabilityDataProviderInterface $availabilityDataProvider)
    {
        $this->availabilityDataProvider = $availabilityDataProvider;
    }
}