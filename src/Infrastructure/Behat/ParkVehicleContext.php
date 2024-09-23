<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\ParkVehicleCommand;
use App\Application\Query\FindVehicleQuery;
use App\Application\Query\FindVehicleQueryHandler;
use App\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use App\Infrastructure\Behat\Trait\DatabaseContextTrait;
use App\Infrastructure\Behat\Trait\ExceptionContextTrait;
use App\Infrastructure\Behat\Trait\FleetContextTrait;
use App\Infrastructure\Behat\Trait\LocationContextTrait;
use App\Infrastructure\Behat\Trait\VehicleContextTrait;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

use function sprintf;

final class ParkVehicleContext implements Context
{
    use DatabaseContextTrait;
    use ExceptionContextTrait;
    use FleetContextTrait;
    use LocationContextTrait;
    use VehicleContextTrait;

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly FindVehicleQueryHandler $findVehicleQueryHandler,
    ) {
    }

    /**
     * @When I park my vehicle at this location
     * @Given my vehicle has been parked into this location
     */
    public function iParkMyVehicleToThisLocation(): void
    {
        $command = new ParkVehicleCommand(
            location: $this->currentLocation,
            vehicle: $this->currentVehicle,
        );

        $this->commandBus->dispatch($command);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        $query = new FindVehicleQuery($this->currentVehicle->getId());

        $vehicle = ($this->findVehicleQueryHandler)($query);

        Assert::assertEquals(
            $this->currentLocation,
            $vehicle->getLocation(),
        );
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->iParkMyVehicleToThisLocation();
        } catch (VehicleAlreadyParkedAtLocationException $exception) {
            $this->currentException = $exception;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        Assert::assertInstanceOf(
            VehicleAlreadyParkedAtLocationException::class,
            $this->currentException,
        );

        $message = sprintf(
            'Vehicle with id "%s" is already parked at location.',
            $this->currentVehicle->getPlateNumber(),
        );
        Assert::assertEquals(
            $message,
            $this->currentException->getMessage(),
        );
    }
}
