<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Application\Command\CommandBusInterface;
use App\Application\Query\FindVehicleQuery;
use App\Application\Query\QueryBusInterface;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Infrastructure\Behat\Trait\DatabaseContextTrait;
use App\Infrastructure\Behat\Trait\ExceptionContextTrait;
use App\Infrastructure\Behat\Trait\FleetContextTrait;
use App\Infrastructure\Behat\Trait\VehicleContextTrait;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

use function sprintf;

final class RegisterVehicleContext implements Context
{
    use DatabaseContextTrait;
    use ExceptionContextTrait;
    use FleetContextTrait;
    use VehicleContextTrait;

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $query = new FindVehicleQuery($this->currentVehicle->getId());

        $vehicle = $this->queryBus->ask($query);

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
