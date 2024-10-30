<?php

declare(strict_types=1);

namespace App\Lleego\Availability\Application;

class GetAvailabilityDataProviderRequest
{
    private ?string $origin;
    private ?string $destination;
    private ?string $date;

    public static function createFromArray(array $params)
    {
        $getDataProviderRequest = new self();
        $getDataProviderRequest->origin = $params['origin'] ?? null;
        $getDataProviderRequest->destination = $params['destination'] ?? null;
        $getDataProviderRequest->date = $params['date'] ?? null;

        return $getDataProviderRequest;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }
}