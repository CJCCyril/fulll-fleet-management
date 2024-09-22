<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Application\Command\CreateFleetCommandHandler;
use App\Application\Command\CreateVehicleCommandHandler;
use App\Application\Command\RegisterVehicleCommandHandler;
use App\Application\Query\FindVehicleQuery;
use App\Application\Query\FindVehicleQueryHandler;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Infrastructure\Behat\Trait\DatabaseContextTrait;
use App\Infrastructure\Behat\Trait\ExceptionContextTrait;
use App\Infrastructure\Behat\Trait\FleetContextTrait;
use App\Infrastructure\Behat\Trait\VehicleContextTrait;
use App\Infrastructure\Persistence\InMemory\InMemoryFleetRepository;
use App\Infrastructure\Persistence\InMemory\InMemoryVehicleRepository;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

use function sprintf;

final class RegisterVehicleContext implements Context
{
    use DatabaseContextTrait;
    use ExceptionContextTrait;
    use FleetContextTrait;
    use VehicleContextTrait;

    private FindVehicleQueryHandler $findVehicleQueryHandler;

    public function __construct()
    {
        $fleetRepository = new InMemoryFleetRepository();
        $vehicleRepository = new InMemoryVehicleRepository();

        $this->createFleetCommandHandler = new CreateFleetCommandHandler($fleetRepository);
        $this->createVehicleCommandHandler = new CreateVehicleCommandHandler($vehicleRepository);
        $this->registerVehicleCommandHandler = new RegisterVehicleCommandHandler($vehicleRepository);
        $this->findVehicleQueryHandler = new FindVehicleQueryHandler($vehicleRepository);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $query = new FindVehicleQuery($this->currentVehicle->getId());

        $vehicle = ($this->findVehicleQueryHandler)($query);

        Assert::assertContains(
            $this->currentFleet,
            $vehicle->getFleets(),
        );
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->iRegisterThisVehicleIntoMyFleet();
        } catch (VehicleAlreadyRegisteredException $exception) {
            $this->currentException = $exception;
        }
    }

    /**
     * @Then I should be informed that this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThatThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        Assert::assertInstanceOf(
            VehicleAlreadyRegisteredException::class,
            $this->currentException,
        );

        $message = sprintf(
            'Vehicle "%s" is already registered.',
            $this->currentVehicle->getPlateNumber(),
        );
        Assert::assertEquals(
            $message,
            $this->currentException->getMessage(),
        );
    }
}
