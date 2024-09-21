<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Infrastructure\Behat\Trait\FleetContextTrait;
use App\Infrastructure\Behat\Trait\LocationContextTrait;
use App\Infrastructure\Behat\Trait\VehicleContextTrait;
use Behat\Behat\Context\Context;

final readonly class ParkVehicleContext implements Context
{
    use FleetContextTrait;
    use LocationContextTrait;
    use VehicleContextTrait;

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
