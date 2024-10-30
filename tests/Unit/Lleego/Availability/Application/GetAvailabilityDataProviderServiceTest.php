<?php

namespace App\Tests\Unit\Lleego\Availability\Application;

use App\Lleego\Availability\Application\GetAvailabilityDataProviderRequest;
use App\Lleego\Availability\Application\GetAvailabilityDataProviderService;
use App\Lleego\Availability\Domain\Segment;
use App\Lleego\Availability\Infrastructure\DataProviderInMemoryRepository;
use PHPUnit\Framework\TestCase;

final class GetAvailabilityDataProviderServiceTest extends TestCase
{
    private DataProviderInMemoryRepository $dataProviderInMemoryRepository;

    public function setUp(): void
    {
        $this->dataProviderInMemoryRepository = new DataProviderInMemoryRepository();
    }

    public function testValidResponse()
    {
        $request = GetAvailabilityDataProviderRequest::createFromArray([
            'origin' => 'MAD',
            'destination' => 'BIO',
            'date' => '2022-06-01' 
        ]);
        $service = new GetAvailabilityDataProviderService($this->dataProviderInMemoryRepository);
        $getAvailabilityDataProviderResponse = $service->execute($request);

        $this->assertEquals(2, count($getAvailabilityDataProviderResponse));
        $this->assertInstanceOf(Segment::class, $getAvailabilityDataProviderResponse[0]);
        $this->assertInstanceOf(Segment::class, $getAvailabilityDataProviderResponse[1]);
        $this->assertEquals('0427', $getAvailabilityDataProviderResponse[1]->getTransportNumber());
    }
}