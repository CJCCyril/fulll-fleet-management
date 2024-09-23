<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Application\Command\CreateVehicleCommand;
use App\Application\Command\RegisterVehicleCommand;
use App\Domain\Model\Vehicle;

trait VehicleContextTrait
{
    private Vehicle $currentVehicle;

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $command = new CreateVehicleCommand('GG-123-WP');

        $this->currentVehicle = $this->commandBus->dispatch($command);
    }

    /**
     * @When I register this vehicle into my fleet
     * @Given I have registered this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $command = new RegisterVehicleCommand(
            fleet: $this->currentFleet,
            vehicle: $this->currentVehicle,
        );

        $this->commandBus->dispatch($command);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserFleet(): void
    {
        $command = new RegisterVehicleCommand(
            fleet: $this->anotherFleet,
            vehicle: $this->currentVehicle,
        );

        $this->commandBus->dispatch($command);
    }
}
