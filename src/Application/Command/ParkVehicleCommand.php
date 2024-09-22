<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

final readonly class ParkVehicleCommand
{
    public function __construct(
        public Location $location,
        public Vehicle $vehicle,
    ) {
    }
}
