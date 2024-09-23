<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\CreateVehicleCommand;
use App\Application\Command\CreateVehicleCommandHandler;
use App\Application\Command\RegisterVehicleCommand;
use App\Application\Command\RegisterVehicleCommandHandler;
use App\Application\Query\FindFleetQuery;
use App\Application\Query\FindFleetQueryHandler;
use App\Application\Query\FindVehicleByPlateNumberQuery;
use App\Application\Query\FindVehicleByPlateNumberQueryHandler;
use App\Domain\Exception\MissingResourceException;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
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
     * @var positive-int
     */
    private int|null $fleetId = null;

    /**
     * @var non-empty-string|null
     */
    private string|null $vehiclePlateNumber = null;

    public function __construct(
        private readonly FindFleetQueryHandler $findFleetQueryHandler,
        private readonly FindVehicleByPlateNumberQueryHandler $findVehicleByPlateNumber,
        private readonly CreateVehicleCommandHandler $createVehicleCommandHandler,
        private readonly RegisterVehicleCommandHandler $registerVehicleCommandHandler,
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
            $fleet = ($this->findFleetQueryHandler)($query);
        } catch (MissingResourceException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::INVALID;
        }

        $vehicle = $this->getVehicle();

        try {
            $command = new RegisterVehicleCommand(
                fleet: $fleet,
                vehicle: $vehicle,
            );
            ($this->registerVehicleCommandHandler)($command);
        } catch (VehicleAlreadyRegisteredException $exception) {
            $output->writeln(
                sprintf('<fg=yellow>"%s"</>', $exception->getMessage())
            );

            return Command::FAILURE;
        }

        $output->writeln('<fg=green>Vehicle successfully registered.</>');

        return Command::SUCCESS;
    }

    private function getVehicle(): Vehicle
    {
        try {
            //@phpstan-ignore argument.type (Cannot be null at this point)
            $query = new FindVehicleByPlateNumberQuery($this->vehiclePlateNumber);
            $vehicle = ($this->findVehicleByPlateNumber)($query);
        } catch (MissingResourceException) {
            //@phpstan-ignore argument.type (Cannot be null at this point)
            $command = new CreateVehicleCommand($this->vehiclePlateNumber);
            $vehicle = ($this->createVehicleCommandHandler)($command);
        }

        return $vehicle;
    }
}
