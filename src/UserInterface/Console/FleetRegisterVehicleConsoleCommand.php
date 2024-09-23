<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\CreateVehicleCommand;
use App\Application\Command\RegisterVehicleCommand;
use App\Application\Query\FindFleetQuery;
use App\Application\Query\FindVehicleByPlateNumberQuery;
use App\Application\Query\QueryBusInterface;
use App\Domain\Exception\MissingResourceException;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Exception\VehicleInvalidPlateNumberException;
use App\Domain\Model\Vehicle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function is_string;

#[AsCommand(name: 'fleet:register-vehicle', description: 'Create and register a vehicle into the fleet')]
class FleetRegisterVehicleConsoleCommand extends Command
{
    /**
     * @var positive-int|null
     */
    private int|null $fleetId = null;

    /**
     * @var non-empty-string|null
     */
    private string|null $vehiclePlateNumber = null;

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'fleetId',
                InputArgument::REQUIRED,
                'The id of the fleet.'
            )
            ->addArgument(
                'vehiclePlateNumber',
                InputArgument::REQUIRED,
                'The plate number of the vehicle.'
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $fleetId = $input->getArgument('fleetId');

        if (empty($fleetId) || !is_numeric($fleetId) || 0 >= $fleetId) {
            $output->writeln('<fg=yellow>Parameter "fleetId" must be a positive integer.</>');

            return;
        }

        // @phpstan-ignore assign.propertyType (it is safe to cast here)
        $this->fleetId = (int) $fleetId;

        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        if (empty($vehiclePlateNumber) || !is_string($vehiclePlateNumber)) {
            $output->writeln('<fg=yellow>Parameter "vehiclePlateNumber" must be a non empty string.</>');

            return;
        }

        $this->vehiclePlateNumber = $vehiclePlateNumber;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        if (!$this->fleetId || !$this->vehiclePlateNumber) {
            return Command::INVALID;
        }

        try {
            $query = new FindFleetQuery($this->fleetId);
            $fleet = $this->queryBus->ask($query);
        } catch (MissingResourceException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::INVALID;
        }

        $vehicle = $this->getVehicle();

        if (!$vehicle) {
            try {
                $command = new CreateVehicleCommand($this->vehiclePlateNumber);
                $vehicle = $this->commandBus->dispatch($command);
            } catch (VehicleInvalidPlateNumberException $exception) {
                $output->writeln(
                    sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
                );

                return Command::INVALID;
            }
        }

        try {
            $command = new RegisterVehicleCommand(
                fleet: $fleet,
                vehicle: $vehicle,
            );
            $this->commandBus->dispatch($command);
        } catch (VehicleAlreadyRegisteredException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::FAILURE;
        }

        $output->writeln('<fg=green>Vehicle successfully registered.</>');

        return Command::SUCCESS;
    }

    private function getVehicle(): Vehicle|null
    {
        try {
            //@phpstan-ignore argument.type (Cannot be null at this point)
            $query = new FindVehicleByPlateNumberQuery($this->vehiclePlateNumber);
            $vehicle = $this->queryBus->ask($query);
        } catch (MissingResourceException) {
            return  null;
        }

        return $vehicle;
    }
}
