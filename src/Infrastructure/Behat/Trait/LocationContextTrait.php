<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Application\Command\CreateLocationCommand;
use App\Application\Command\CreateLocationCommandHandler;
use App\Domain\Model\Location;

trait LocationContextTrait
{
    private Location $currentLocation;
    private CreateLocationCommandHandler $createLocationCommand;

    /**
     * @Given a location
     */
    public function aLocation(): void
    {
        $command = new CreateLocationCommand(
            latitude: 43.455252,
            longitude: 5.475261,
        );

        $this->currentLocation = ($this->createLocationCommand)($command);
    }
}
