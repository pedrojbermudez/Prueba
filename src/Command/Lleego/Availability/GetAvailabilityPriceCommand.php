<?php

namespace App\Command\Lleego\Availability;

use App\Lleego\Availability\Application\GetAvailabilityDataProviderRequest;
use App\Lleego\Availability\Application\GetAvailabilityDataProviderService;
use App\Lleego\Shared\Domain\Response\JsonResponse;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'lleego:avail',
    description: 'Get availability price',
)]
class GetAvailabilityPriceCommand extends Command
{
    private $getProviderDataService;

    public function __construct(GetAvailabilityDataProviderService $getProviderDataService)
    {
        parent::__construct();

        $this->getProviderDataService = $getProviderDataService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('origin', InputArgument::REQUIRED, 'Airport of origin. Example: MAD')
            ->addArgument('destination', InputArgument::REQUIRED, 'Airport of origin. Example: BIO')
            ->addArgument('date', InputArgument::REQUIRED, 'Departure date. Example: 2022-06-01')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $origin = $input->getArgument('origin');
        $destination = $input->getArgument('destination');
        $date = $input->getArgument('date');

        $getDataProviderRequest = GetAvailabilityDataProviderRequest::createFromArray([
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date,
        ]);
        $getDataProviderResponse = $this->getProviderDataService->execute($getDataProviderRequest);
        $getDataProviderResponseJsonArray = JsonResponse::convertObjectToArray($getDataProviderResponse);

        $table = new Table($output);
        $table->setHeaders([
            'Origin Code', 
            'Origin Name', 
            'Destination Code', 
            'Destination Name', 
            'Start', 
            'End', 
            'Transport Number', 
            'Company Code', 
            'Company Name'
        ])->setRows($getDataProviderResponseJsonArray)
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
