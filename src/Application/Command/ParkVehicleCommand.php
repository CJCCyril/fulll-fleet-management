<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

/**
 * @implements CommandInterface<void>
 */
final readonly class ParkVehicleCommand implements CommandInterface
{
    public function __construct(
        public Location $location,
        public Vehicle $vehicle,
    ) {
    }
}
