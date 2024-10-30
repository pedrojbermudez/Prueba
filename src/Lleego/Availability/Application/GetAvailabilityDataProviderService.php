<?php

declare(strict_types=1);

namespace App\Lleego\Availability\Application;

use App\Lleego\Availability\Domain\Segment;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GetAvailabilityDataProviderService extends AvailabilityDataProviderService
{
    public function execute(GetAvailabilityDataProviderRequest $getProviderDataRequest): array
    {
        if ($getProviderDataRequest->getOrigin() === null) {
            throw new BadRequestException('Origin param required');
        }

        if ($getProviderDataRequest->getDestination() === null) {
            throw new BadRequestException('Destination param required');
        }

        if ($getProviderDataRequest->getDate() === null) {
            throw new BadRequestException('Date param required');
        }

        $date = null;

        try {
            $date = new DateTime($getProviderDataRequest->getDate());
        } catch (Exception $e) {
            throw new BadRequestException('Invalid date format');
        }

        $data = $this->availabilityDataProvider->getXmlDataAsArray(
            $getProviderDataRequest->getOrigin(),
            $getProviderDataRequest->getDestination(),
            $date
        );

        return $this->format($data);
    }

    /**
     * Only need the xpath: AirShoppingRS/DataLists/FlightSegmentList/FlightSegment
     * 
     * @param array $xmlArrayData
     * 
     * @return ?array
     */
    private function format($xmlArrayData)
    {
        if (!isset($xmlArrayData['DataLists']['FlightSegmentList']['FlightSegment'])) {
            return null;
        }

        $dataExtracted = $xmlArrayData['DataLists']['FlightSegmentList']['FlightSegment'];
        $segments = [];

        foreach ($dataExtracted as $data) {
            $departure = $data['Departure'];
            $arrival = $data['Arrival'];
            $marketingCarrier = $data['MarketingCarrier'];

            $originCode = $departure['AirportCode'];
            $originName = $departure['AirportName'];

            $destinationCode = $arrival['AirportCode'];
            $destinationName = $arrival['AirportName'];

            $start = new DateTime($departure['Date'] . ' ' . $departure['Time']);
            $end = new DateTime($arrival['Date']);

            /*
                He visto que end no incluye ahora, yo creo que deberia incluirla
                pero lo dejare sin hora tal y como aparece en el pdf por mantener
                el formato requerido.

                Aun asi dejo esa linea comentada y lo dejo con vuestro requerimiento
            */

            $end = new DateTime($arrival['Date'] . ' ' . $arrival['Time']);

            $transportNumber = $marketingCarrier['FlightNumber'];
            $companyCode = $marketingCarrier['AirlineID'];
            $companyName = $marketingCarrier['Name'];

            $segments[] = (new Segment())
                ->setOriginCode($originCode)
                ->setOriginName($originName)
                ->setDestinationCode($destinationCode)
                ->setDestinationName($destinationName)
                ->setStart($start)
                ->setEnd($end)
                ->setTransportNumber($transportNumber)
                ->setCompanyCode($companyCode)
                ->setCompanyName($companyName);
        }

        return $segments;
    }
}