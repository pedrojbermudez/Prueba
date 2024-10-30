<?php

namespace App\Tests\Unit\Lleego\Shared\Domain\Response;

use App\Lleego\Shared\Domain\Response\JsonResponse;
use App\Lleego\Availability\Domain\Segment;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

final class JsonResponseTest extends TestCase
{
    public function testValidJsonSingleResponse()
    {
        $originCode = 'MAD';
        $originName = 'Madrid Adolfo Suarez-Barajas';

        $destinationCode = 'BIO';
        $destinationName = 'Bilbao';

        $start = new DateTime(date('Y-m-d H:i'));
        $end = new DateTime(date('Y-m-d'));

        $transportNumber = '0426';
        $companyCode = 'IB';
        $companyName = 'Iberia';
        $object = (new Segment())
                ->setOriginCode($originCode)
                ->setOriginName($originName)
                ->setDestinationCode($destinationCode)
                ->setDestinationName($destinationName)
                ->setStart($start)
                ->setEnd($end)
                ->setTransportNumber($transportNumber)
                ->setCompanyCode($companyCode)
                ->setCompanyName($companyName);

        $response = JsonResponse::convertObjectToArray($object);
        $this->assertEquals('MAD', $response['originCode']);
    }

    public function testValidJsonMultipleResponse()
    {
        $originCode = 'MAD';
        $originName = 'Madrid Adolfo Suarez-Barajas';

        $destinationCode = 'BIO';
        $destinationName = 'Bilbao';

        $start = new DateTime(date('Y-m-d H:i'));
        $end = new DateTime(date('Y-m-d'));

        $transportNumber = '0426';
        $companyCode = 'IB';
        $companyName = 'Iberia';
        $objects = [
            (new Segment())
                ->setOriginCode($originCode)
                ->setOriginName($originName)
                ->setDestinationCode($destinationCode)
                ->setDestinationName($destinationName)
                ->setStart($start)
                ->setEnd($end)
                ->setTransportNumber($transportNumber)
                ->setCompanyCode($companyCode)
                ->setCompanyName($companyName),
            (new Segment())
                ->setOriginCode($originCode . '2')
                ->setOriginName($originName)
                ->setDestinationCode($destinationCode)
                ->setDestinationName($destinationName)
                ->setStart($start)
                ->setEnd($end)
                ->setTransportNumber($transportNumber)
                ->setCompanyCode($companyCode)
                ->setCompanyName($companyName)
        ];

        $response = JsonResponse::convertObjectToArray($objects);
        $this->assertEquals(2, count($response));
        $this->assertEquals('MAD', $response[0]['originCode']);
        $this->assertEquals('MAD2', $response[1]['originCode']);
    }

    public function testNoToArrayMethod()
    {
        $this->expectException(Exception::class);
        $response = JsonResponse::convertObjectToArray(new stdClass());
    }
}