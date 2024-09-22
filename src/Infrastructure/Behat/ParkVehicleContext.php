<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Application\Command\CreateFleetCommandHandler;
use App\Application\Command\CreateVehicleCommandHandler;
use App\Application\Command\RegisterVehicleCommandHandler;
use App\Infrastructure\Behat\Trait\DatabaseContextTrait;
use App\Infrastructure\Behat\Trait\ExceptionContextTrait;
use App\Infrastructure\Behat\Trait\FleetContextTrait;
use App\Infrastructure\Behat\Trait\LocationContextTrait;
use App\Infrastructure\Behat\Trait\VehicleContextTrait;
use App\Infrastructure\Persistence\InMemory\InMemoryFleetRepository;
use App\Infrastructure\Persistence\InMemory\InMemoryVehicleRepository;
use Behat\Behat\Context\Context;

final class ParkVehicleContext implements Context
{
    use DatabaseContextTrait;
    use ExceptionContextTrait;
    use FleetContextTrait;
    use LocationContextTrait;
    use VehicleContextTrait;

    public function __construct()
    {
        $fleetRepository = new InMemoryFleetRepository();
        $vehicleRepository = new InMemoryVehicleRepository();

        $this->createFleetCommandHandler = new CreateFleetCommandHandler($fleetRepository);
        $this->createVehicleCommandHandler = new CreateVehicleCommandHandler($vehicleRepository);
        $this->registerVehicleCommandHandler = new RegisterVehicleCommandHandler($vehicleRepository);
    }

    /**
     * @When I park my vehicle at this location
     * @Given my vehicle has been parked into this location
     */
    public function iParkMyVehicleToThisLocation(): void
    {
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        throw new \Exception();
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        throw new \Exception();
    }
}
