<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Application\Command\CreateFleetCommand;
use App\Application\Command\CreateFleetCommandHandler;
use App\Domain\Model\Fleet;

trait FleetContextTrait
{
    private Fleet $currentFleet;
    private Fleet $anotherFleet;

    private CreateFleetCommandHandler $createFleetCommandHandler;

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $command = new CreateFleetCommand('currentUser');

        $this->currentFleet = ($this->createFleetCommandHandler)($command);
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser(): void
    {
        $command = new CreateFleetCommand('anotherUser');

        $this->anotherFleet = ($this->createFleetCommandHandler)($command);
    }
}
