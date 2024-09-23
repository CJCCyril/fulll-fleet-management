<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Application\Command\CreateFleetCommand;
use App\Domain\Model\Fleet;

trait FleetContextTrait
{
    private Fleet $currentFleet;
    private Fleet $anotherFleet;

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $command = new CreateFleetCommand('currentUser');

        $this->currentFleet = $this->commandBus->dispatch($command);
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser(): void
    {
        $command = new CreateFleetCommand('anotherUser');

        $this->anotherFleet = $this->commandBus->dispatch($command);
    }
}
