<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

trait FleetContextTrait
{
    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
    }

    /**
     * @When I register this vehicle into my fleet
     * @Given I have registered this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser(): void
    {
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserFleet(): void
    {
    }
}
