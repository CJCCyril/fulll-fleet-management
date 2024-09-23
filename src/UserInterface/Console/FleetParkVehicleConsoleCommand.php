<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\ParkVehicleCommand;
use App\Application\Command\ParkVehicleCommandHandler;
use App\Application\Query\FindVehicleByPlateNumberQuery;
use App\Application\Query\FindVehicleByPlateNumberQueryHandler;
use App\Domain\Exception\MissingResourceException;
use App\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use App\Domain\Model\Location;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function is_string;

#[AsCommand(name: 'fleet:park-vehicle', description: 'Park a vehicle to a location')]
class FleetParkVehicleConsoleCommand extends Command
{
    /**
     * @var non-empty-string|null
     */
    private string|null $vehiclePlateNumber = null;

    private float|null $latitude = null;
    private float|null $longitude = null;

    /**
     * @var float|false|null
     *
     * null if not specified
     * false for an invalid value
     */
    private float|null|false $altitude = null;

    public function __construct(
        private readonly FindVehicleByPlateNumberQueryHandler $findVehicleByPlateNumber,
        private readonly ParkVehicleCommandHandler $parkVehicleCommandHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'vehiclePlateNumber',
                InputArgument::REQUIRED,
                'The plate number of the vehicle.'
            )
            ->addArgument(
                'latitude',
                InputArgument::REQUIRED,
                'The latitude of the vehicle\'s position. Latitude is a geographic coordinate.'
            )
            ->addArgument(
                'longitude',
                InputArgument::REQUIRED,
                'The longitude of the vehicle\'s position. longitude is a geographic coordinate.'
            )
            ->addArgument(
                'altitude',
                InputArgument::OPTIONAL,
                'The altitude of the vehicle\'s position in meters.'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        if (empty($vehiclePlateNumber) || !is_string($vehiclePlateNumber)) {
            $output->writeln('<fg=yellow>Parameter "vehiclePlateNumber" must be a non empty string.</>');

            return;
        }

        $this->vehiclePlateNumber = $vehiclePlateNumber;

        $latitude = $input->getArgument('latitude');

        if (empty($latitude) || !is_numeric($latitude) || !is_float((float) $latitude)) {
            $output->writeln('<fg=yellow>Parameter "latitude" must be a floating point.</>');

            return;
        }

        $this->latitude = (float) $latitude;

        $longitude = $input->getArgument('longitude');

        if (empty($longitude) || !is_numeric($longitude) || !is_float((float) $longitude)) {
            $output->writeln('<fg=yellow>Parameter "longitude" must be a floating point.</>');

            return;
        }

        $this->longitude = (float) $longitude;

        $altitude = $input->getArgument('altitude');

        if (!empty($altitude)) {
            if (!is_numeric($altitude) || !is_float((float) $altitude)) {
                $output->writeln('<fg=yellow>Parameter "altitude" must be a floating point.</>');

                $this->altitude = false;
                return;
            }
        }

        $this->altitude = (float) $altitude;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        if (
            !$this->vehiclePlateNumber ||
            !$this->latitude ||
            !$this->longitude ||
            false === $this->altitude
        ) {
            return Command::INVALID;
        }

        try {
            $query = new FindVehicleByPlateNumberQuery($this->vehiclePlateNumber);
            $vehicle = ($this->findVehicleByPlateNumber)($query);
        } catch (MissingResourceException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::INVALID;
        }

        $location = new Location(
            latitude: $this->latitude,
            longitude: $this->longitude,
            altitude: $this->altitude,
        );

        try {
            $command = new ParkVehicleCommand(
                location: $location,
                vehicle: $vehicle,
            );
            ($this->parkVehicleCommandHandler)($command);
        } catch (VehicleAlreadyParkedAtLocationException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::FAILURE;
        }

        $output->writeln('<fg=green>Vehicle successfully parked.</>');

        return Command::SUCCESS;
    }
}
